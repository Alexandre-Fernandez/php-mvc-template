<?php declare(strict_types=1);
namespace App\Components\Products;

class Controller extends \App\Controller {
	public function getProducts() {
		$productsPerPage = 20;
		$page = (int)$_GET["p"] ?? 0;
		$orderBy = $_GET["orderBy"] ? htmlentities($_GET["orderBy"]) : "name";
		$sort = $_GET["sort"] ? htmlentities($_GET["sort"]) : "ASC";

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
			"sort" => $sort
		]);
	}
}