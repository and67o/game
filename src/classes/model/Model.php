<?php


namespace Router\src\classes\model;


use Router\Db;

class Model
{
	/**
	 * Возвращает объект DB для работы с БД по умолчанию.
	 * @return DB
	 */
	protected static function _db()
	{
		return Db::getInstance();
	}
	
	protected $fields = [];
	private $from = [];
	private $where = [];
	
	public function select(array $fields) : Model
	{
		$this->fields = $fields;
		
		return $this;
	}
	
	public function from(string $table, string $alias) : Model
	{
		$this->from[] = $table . ' AS ' . $alias;
		
		return $this;
	}
	
	public function where(string $condition) : Model
	{
		$this->where[] = $condition;
		
		return $this;
	}
	
	public function __toString() : string
	{
		return sprintf(
			'SELECT %s FROM %s WHERE %s',
			join(', ', $this->fields),
			join(', ', $this->from),
			join(' AND ', $this->where)
		);
	}
	
}
