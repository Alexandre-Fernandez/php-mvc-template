<?php declare(strict_types=1);
namespace App\Components\Products;

class Model extends \App\Model {
	public function retrieveProducts(
		int $offset, 
		int $count, 
		string $orderBy = "name", 
		string $sort = "ASC"
	) {
		try {
			$query = $this->pdo->query(
				"SELECT name, price FROM products ORDER BY $orderBy $sort LIMIT $offset, $count",
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