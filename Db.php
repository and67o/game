<?php


namespace Router;


use PDO;
use PDOStatement;

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
	
	
	const USERNAME = 'admin';
	const PASSWD = '123';
	const HOST = 'localhost';
	const DB_NAME = 'game';
	const DB_OPTIONS = [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES => false,
	];
	
	const FIRST_ELEMENT = 1;
	
	public function __construct()
	{
		try {
			$this->_pdo = new PDO(
				sprintf(
					'mysql:host=%s;dbname=%s',
					self::HOST,
					self::DB_NAME
				),
				self::USERNAME,
				self::PASSWD,
				self::DB_OPTIONS
			);
		} catch (\PDOException $exception) {
			echo 'Подключение не удалось: ' . $exception->getMessage();
			die;
		}
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
		$sql = $query ? : $this->query;
		$this->query = $this->_pdo->prepare($sql);
		$numberInList = self::FIRST_ELEMENT;
		
		foreach ($params as $param) {
			$this->query->bindValue(
				$numberInList,
				$param,
				is_int($param) ? PDO::PARAM_INT : PDO::PARAM_STR
			);
			$numberInList++;
		}
		if ($this->query->execute()) {
			// разнести эти метода на селкт и инсерт
			$this->_result = $this->query->fetchAll(PDO::FETCH_ASSOC);
			//			$this->_count = $this->query->rowCount();
			return $this;
		} else {
			throw new \PDOException('Trouble with DB');
		}
	}
	
	/**
	 * Получить первое значение в результате
	 * @return string
	 */
	public function single() : string
	{
		return count($this->_result)
			? array_shift($this->_result[0])
			: '';
	}
	
	/**
	 * Получить первое значение
	 * @return array
	 */
	public function first() :array {
		return count($this->_result)
			? $this->_result[0]
			: [];
	}
	
	/**
	 * возвращает последний id
	 * @return string
	 */
	public function getLastId()
	{
		return $this->_pdo->lastInsertId();
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
	 * Вернуть кол-во
	 * @return mixed
	 */
	public function count()
	{
		return $this->_count;
	}
	
	public function beginTransaction()
	{
		return $this->_pdo->beginTransaction();
	}
	
	public function endTransaction()
	{
		return $this->_pdo->commit();
	}
	
	public function cancelTransaction()
	{
		return $this->_pdo->rollBack();
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
	 * @param array $param
	 * @return Db
	 */
	public function get(array $param)
	{
		$this->query = sprintf(
			'SELECT %s FROM %s WHERE %s',
			join(', ', $this->fields),
			join(', ', $this->table),
			join(' AND ', $this->where)
		);
		return $this->queryPrepare($param);
	}
	
	/**
	 * Вставка
	 * @param $params
	 * @return string
	 */
	public function add($params)
	{
		if (!is_array($params)) {
			$params = (array) $params;
		}
		$keys = array_keys($params);
		$countOfParam = count($params);
		$values = '';
		for ($numberOfList = 1; $numberOfList <= $countOfParam; $numberOfList++) {
			$values .= '?';
			if ($numberOfList < $countOfParam) {
				$values .= ', ';
			}
		}
		$this->query = sprintf(
			'INSERT INTO %s (`%s`) VALUES (%s)',
			join(', ', $this->table),
			implode('`, `', $keys),
			$values
		);
		$res = $this->queryPrepare($params);
		if (!$res) {
			throw new \PDOException('not add');
		}
		return $res->getLastId();
	}
}
