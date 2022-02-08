<?php declare(strict_types=1);
namespace App\Abstracts;

use \PDO;

abstract class Model {
	protected PDO $pdo;
	
	/**
	 * @param  PDO $pdo get PDO from \App\Database
	 */
	public function __construct(PDO $pdo) {
		$this->pdo = $pdo;
	}
}