<?php


namespace Router;


use PDO;
use Router\Models\QueryBuilder;
use Router\src\classes\model\Model;

class Db
{
	private static $_instance = null;
	
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
			self::$_instance = new PDO(
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
				$sql = preg_replace('(\?\?|\?|\'|"|\\))', $param, $sql, 1);
			}
		}
		return $sql;
	}
	
	public function bindValue($sql, array $params = [])
	{
		for ($index = 0; $index < count($params); $index++) {
			$sql->bindValue(
				$index + 1,
				$params[$index],
				is_int($params) ? PDO::PARAM_INT : PDO::PARAM_STR
			);
		}

		return $sql;
	}

	/**
	 * получить первое значение из SELECT
	 * @param $sql
	 * @param array $params
	 * @return string
	 */
	public function fetchFirstField($sql, $params = [])
	{
		try {
			$sql = $this->bindValue(
				self::$_instance->prepare($sql),
				$params
			);
			$sql->execute();
		} catch (\PDOException $error) {
			var_dump($error);
		}
		$result = $sql->fetch(PDO::FETCH_ASSOC);
		return $result ? (string) array_shift($result) : '';
	}
	
	/**
	 * Получить все значения из SELECT
	 * @param $sql - запрос
	 * @param array $params
	 * @return array
	 */
	public function fetchAll($sql, $params = []) : array
	{
		$result = [];
		try {
			$sql = $this->bindValue(
				self::$_instance->prepare($sql),
				$params
			);
			$sql->execute();
		} catch (\PDOException $error) {
			var_dump($error);
		}
		while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
			$result[] = $row;
		}
		return $result;
	}
	
	/**
	 * Выполнение запроса
	 * @param string $sql
	 * @return bool
	 */
	public function query(string $sql) : bool
	{
		return mysqli_query(self::$_instance, $sql);
	}
	
	public function getLastId()
	{
		return mysqli_insert_id(self::$_instance);
	}
	
	public function closeConnection()
	{
		mysqli_close(self::$_instance);
	}
	
}
