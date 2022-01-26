<?php declare(strict_types=1);
namespace App;

use \PDO;

class Database {
	private static $pdo;

	public static function init(
		string $hostname, 
		string $name, 
		string $username, 
		string $password
	) {
		self::$pdo = new PDO("mysql:host=$hostname;dbname=$name", $username, $password, [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
		]);
	}

	public static function getPdo(): PDO {
		return self::$pdo;
	}
}