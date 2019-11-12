<?php


namespace Router\src\classes\interfaces;


abstract class CrudEssence
{
	private $essence;

	public function __construct($essence = [])
	{
		$this->essence = $essence;
	}

	public function exists($name)
	{
		return isset($this->essence[$name]);
	}

	public function get($name)
	{
		return $this->essence[$name];
	}

	public function delete($name)
	{
		if ($this->exists($name)) {
			unset($this->essence[$name]);
		}
	}

}