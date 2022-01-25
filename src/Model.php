<?php declare(strict_types=1);
namespace App;

use \PDO;

abstract class Model {
	protected PDO $pdo;

	public function __construct() {
		$this->pdo = \App\Database::getPdo();
	}
}