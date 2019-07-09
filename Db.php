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

//		self::$_instance = new \PDO(
//			'mysql:host=' . $config['db']['server'] . ';dbname=' . $config['db']['name'],
//			$config['db']['username'],
//			$config['db']['password'],
//			[\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"]
//		);

	}

	private function __wakeup () {}

	private function __clone () {}

	public static function getInstance()
	{
		if (self::$_instance != null) {
			return self::$_instance;
		}

		return new self;
	}

	public function sqlGet($sql, $keyField, $field = '')
	{
		$sqlRes = [];
		$result = self::$_instance->query($sql);
		if ($result->num_rows) {
			if ($keyField && $field) {
				while ($row = $result->fetch_assoc()) {
					$sqlRes[$row[$keyField]] = $row[$field];
				}
			} elseif ($keyField && !$field) {
				while ($row = $result->fetch_assoc()) {
					$sqlRes[] = $row[$keyField];
				}
			}

		}
		return $sqlRes;
	}

	public function sqlGetAll($sql)
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

	public function query($sql)
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