<?php declare(strict_types=1);
namespace App\Components\Products;

class Router extends \App\Lib\Router {
	protected function addRoutes(): void {
		$this->get("/", "getProducts");
	}
}