<?php

class Singleton
{
	private static $object = null;
	private $pdo = null;

	protected function __construct()
	{
		$host = 'localhost';
		$db = 'jewelry';
		$user = 'root';
		$pass = '';
		$charset = 'utf8';
		$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
		$opt = [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES => false,
		];
		$this->pdo = new PDO($dsn, $user, $pass, $opt);
	}

	public function __wakeup() {}

	private function __clone() {}

	public static function getObject()
	{
		if (self::$object == null) {
			self::$object = new static();
		}
		return self::$object;
	}

	static function connection()
	{
		return (static::getObject())->pdo;
	}

	static function prepare($expression)
	{
		return (static::connection())->prepare($expression);
	}

}
