<?php

namespace Router;

use PDO;

class Db
{
	private static $_instance = null;
	protected $query;
	private $_pdo;
	private $_result;
	private $_count;
	private $where;
	private $table;
	private $fields;
	
	const DB_OPTIONS = [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES => false,
	];
	
	const FIRST_ELEMENT = 1;
	
	public function __construct()
	{
		try {
			$this->setPDO();
		} catch (\PDOException $exception) {
			echo 'Подключение не удалось: ' . $exception->getMessage();
			die;
		}
	}
    
    /**
     * @return void
     */
	public function setPDO() {
        $this->_pdo = new PDO(
            sprintf(
                'mysql:host=%s;dbname=%s',
                getenv('MYSQL_HOST'),
                getenv('MYSQL_DATABASE')
            ),
            getenv('MYSQL_USER'),
            getenv('MYSQL_PASSWORD'),
            self::DB_OPTIONS
        );
    }
	
	private function __wakeup()
	{
	}
	
	private function __clone()
	{
	}
	
	public static function getInstance()
	{
		if (self::$_instance != null) {
			return self::$_instance;
		}
		
		return new self;
	}
	
	/**
	 * Выполнение запроса
	 * @param $params
	 * @param string $query
	 * @return Db
	 */
	public function queryPrepare($params, $query = '')
	{
		$params = is_array($params) ? $params : (array) $params;
		$sql = $query ? : $this->getQuery();
        $this->setQuery($this->getPDO()->prepare($sql));
		$numberInList = self::FIRST_ELEMENT;
		
		foreach ($params as $param) {
            $this->getQuery()->bindValue(
				$numberInList,
				$param,
				is_int($param) ? PDO::PARAM_INT : PDO::PARAM_STR
			);
			$numberInList++;
		}
		if ($this->getQuery()->execute()) {
			// разнести эти метода на селкт и инсерт
            $this->setResult($this->getQuery()->fetchAll(PDO::FETCH_ASSOC));
			return $this;
		} else {
			throw new \PDOException('Trouble with DB');
		}
	}

    /**
     * @return mixed
     */
	public function getQuery() {
	    return $this->query;
    }
    
    public function setQuery($query) {
	   $this->query = $query;
    }
	
	/**
	 * Получить первое значение в результате
	 * @return string
	 */
	public function single()
	{
	    $res = $this->getResult();
		return count($res)
			? array_shift($res[0])
			: '';
	}
	
	/**
	 * Получить первое значение
	 * @return array
	 */
	public function first()
	{
        $result = $this->getResult();
        reset($result);
        return current($result);
	}
	
	/**
	 * возвращает последний id
	 * @return string
	 */
	public function getLastId()
	{
		return $this->getPDO()->lastInsertId();
	}
	
	/**
	 * Вернуть результат
	 * @return mixed
	 */
	public function getResult()
	{
		return $this->_result;
	}

    /**
     * @param $result
     * @return $this
     */
    public function setResult($result)
    {
        $this->_result = $result;
        return $this;
    }
    
	/**
	 * Вернуть кол-во
	 * @return mixed
	 */
	public function getCount()
	{
		return $this->_count;
	}
    
    /**
     * @param $count
     */
	public function setCount($count)
    {
        $this->_count = $count;
    }
    
    /**
     * @return mixed
     */
	public function beginTransaction()
	{
		return $this->getPDO()->beginTransaction();
	}
    
    /**
     * @return mixed
     */
	public function getPDO() {
	    return $this->_pdo;
    }
    
    /**
     * @return mixed
     */
	public function endTransaction()
	{
		return $this->getPDO()->commit();
	}
    
    /**
     * @return mixed
     */
	public function cancelTransaction()
	{
		return $this->getPDO()->rollBack();
	}
	
	/**
	 * Параметры условия
	 * @param $condition
	 * @return Db
	 */
	public function where($condition) : Db
	{
		$this->where[] = $condition;
		return $this;
	}
	
	/**
	 * Задать название таблицы
	 * @param string $table
	 * @param string $alias
	 * @return Db
	 */
	public function table(string $table, string $alias = '') : Db
	{
		$addAlias = '';
		if ($alias) {
			$addAlias = ' AS ' . $alias;
		}
		$this->table[] = $table . $addAlias;
		return $this;
	}
	
	/**
	 * Параметры выбора
	 * @param array $fields
	 * @return Db
	 */
	public function select(array $fields) : Db
	{
		$this->fields = $fields;
		return $this;
	}
    
    /**
     * @phpunit
     * @return string
     */
	public function setSelectQuery() {
        return sprintf(
            'SELECT %s FROM %s WHERE %s',
            join(', ', $this->getFields()),
            join(', ', $this->getTable()),
            join(' AND ', $this->getWhere())
        );
    }
    
    /**
     * @return array
     */
    protected function getFields() : array {
	    return $this->fields;
    }
    
    /**
     * @return array
     */
    protected function getTable() : array  {
        return $this->table;
    }
    
    /**
     * @return array
     */
    protected function getWhere() : array  {
        return $this->where;
    }
	/**
	 * @param array $param
	 * @return Db
	 */
	public function get(array $param)
	{
		$this->query = $this->setSelectQuery();
		return $this->queryPrepare($param);
	}
	
	/**
	 * Вставка
	 * @param $params
	 * @return string
	 */
	public function add($params)
	{
		$this->setQuery($this->setInsertQuery($params));
        $this->setQuery($this->setInsertQuery($params));
        $res = $this->queryPrepare($params);
		if (!$res) {
			throw new \PDOException('not add');
		}
		return $res->getLastId();
	}
    
    /**
     * @param $params
     * @phpunit
     * @return string
     */
    public function setInsertQuery($params) {
        $params = is_array($params) ? $params : (array) $params;
        $keys = array_keys($params);
        $countOfParam = count($params);
        $table = $this->getTable();
        if (!$countOfParam) {
            return '';
        }
        $values = '';

        for ($numberOfList = 1; $numberOfList <= $countOfParam; $numberOfList++) {
            $values .= '?';
            if ($numberOfList < $countOfParam) {
                $values .= ', ';
            }
        }

        return sprintf(
            'INSERT INTO %s (`%s`) VALUES (%s)',
	        join(', ', $table),
            implode('`, `', $keys),
            $values
        );
    }
}
