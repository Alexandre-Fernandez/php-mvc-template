<?php declare(strict_types=1);
namespace App\Components\Products;

class Model extends \App\Abstracts\Model {
	public function retrieveProducts(
		int $offset, 
		int $count, 
		?string $orderBy = "name", 
		?string $sort = "ASC"
	) {
		try {
			if(!in_array($orderBy, ["name", "price"])) $orderBy = "name";
			if(!in_array($sort, ["ASC", "DESC"])) $sort = "ASC";
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