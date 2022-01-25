<?php declare(strict_types=1);
namespace App\Components\Products;

class Model extends \App\Model {
	public function retrieveProducts() {
		try {
			$query = $this->pdo->query(
				"SELECT name, price FROM products",
				\PDO::FETCH_CLASS,
				"App\\Components\\Products\\Product"
			);
			return $query->fetchAll();
		} 
		catch(\Exception $e) {
			return [];
		}
	}
}