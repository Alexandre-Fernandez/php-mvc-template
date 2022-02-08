<?php declare(strict_types=1);
namespace App\Components\Products;

class Controller extends \App\Abstracts\Controller {
	public function getProducts(array $params = [], array $query = []) {
		$productsPerPage = 20;
		$page = (int)($query["p"] ?? 0);
		$orderBy = $query["orderBy"] ?? "name";
		$sort = $query["sort"] ?? "ASC";

		$products = $this->callModel("retrieveProducts", [
			"offset" => $productsPerPage * $page,
			"count" => $productsPerPage + 1, // adding one index to check for next page
			"orderBy" => $orderBy,
			"sort" => $sort
		]);

		$isLastPage = true;
		if(count($products) > $productsPerPage) {
			array_pop($products); // removing previously added index
			$isLastPage = false;
		}
		
		$this->render("products", "main", [
			"title" => "Products", 
			"products" => $products,
			"page" => $page,
			"isLastPage" => $isLastPage,
			"orderBy" => $orderBy,
			"sort" => $sort,
			"query" => $query
		]);
	}
}