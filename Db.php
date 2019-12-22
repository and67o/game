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
	
	
	const USERNAME = 'admin';
	const PASSWD = '123';
	const HOST = 'localhost';
	const DB_NAME = 'game';
	const DB_OPTIONS = [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES => false,
	];
	
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
	
	public function bindValueRegEx($sql, $params)
	{
		if (count($params)) {
			foreach ($params as $param) {
				$param = is_int($param) ? $param : ('"' . $param . '"');
				$sql = preg_replace('/\?\?|\?|\'|"|\\//', $param, $sql, 1);
			}
		}
		return $sql;
	}
	
	/**
	 * Выполнение запроса
	 * @param $params
	 * @param string $query
	 * @return Db
	 */
	public function queryExecute($params, $query = '') : Db
	{
		if (!is_array($params)) {
			$params = (array) $params;
		}
		$sql = $query ?: $this->query;
		$this->query = $this
			->_pdo
			->prepare($sql);
		$numberInList = 1;
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
			$this->_result = $this->query->fetchAll(PDO::FETCH_OBJ);
//			$this->_count = $this->query->rowCount();
			return $this;
		} else {
			throw new \PDOException('Trouble with DB');
		}
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
	
	public function get($param)
	{
		$this->query = sprintf(
			'SELECT %s FROM %s WHERE %s',
			join(', ', $this->fields),
			join(', ', $this->table),
			join(' AND ', $this->where)
		);
		return $this
			->queryExecute($param)
			->getResult();
	}
	
	/**
	 * Вставка
	 * @param $params
	 * @return Db
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
		$res = $this->queryExecute($params);
		if (!$res) {
			throw new \PDOException('123');
		}
		return $res->getLastId();
	}
}
