<?php declare(strict_types=1);
namespace App;

use \PDO;

class Database {
	public static function getPdo() {
		return new PDO(
			"mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']}", 
			$_ENV["DB_USER"], 
			$_ENV["DB_PASSWORD"], 
			[
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
			]
		);
	}
}