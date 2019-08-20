<?php


namespace Router;


class Db
{
	private static $_instance = null;

	public function __construct()
	{
		$config = [
			'title' => 'Game',
			'db' => [
				'server' => 'localhost',
				'username' => 'admin',
				'password' => '123',
				'name' => 'game'
			],
		];
		self::$_instance = mysqli_connect(
			$config['db']['server'],
			$config['db']['username'],
			$config['db']['password'],
			$config['db']['name']
		);
		self::$_instance->set_charset("utf8");
		if (self::$_instance == false) {
			echo "Соединения нет<br>";
			echo mysqli_connect_error();
			exit();
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
	 * получить первое значение из SELECT
	 * @param $sql
	 * @return mixed
	 */
	public function fetchFirstField($sql)
	{
		$result = self::$_instance->query($sql);
		if ($result->num_rows > 0) {
			$result = $result->fetch_assoc();
			return array_shift($result);
		}
		return false;
	}

	/**
	 * Получить все значения из SELECT
	 * @param $sql - запрос
	 * @return array
	 */
	public function fetchAll($sql) : array
	{
		$sqlRes = [];
		$result = self::$_instance->query($sql);
		if (is_object($result) && $result->num_rows) {
			while ($row = $result->fetch_assoc()) {
				$sqlRes[] = $row;
			}
		}
		return $sqlRes;
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
