<?php declare(strict_types=1);
namespace App\Components\Products;

class Controller extends \App\Controller {
	public function getProducts() {
		$products = $this->callModel("retrieveProducts");
		$this->render("products", "main", [
			"title" => "Products", 
			"products" => $products
		]);
	}
}