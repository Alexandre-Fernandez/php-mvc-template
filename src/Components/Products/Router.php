<?php declare(strict_types=1);
namespace App\Components\Products;

class Router extends \App\Abstracts\Router {
	protected function addRoutes(): void {
		$this->get("/", "getProducts");
	}
}