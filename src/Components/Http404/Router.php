<?php declare(strict_types=1);
namespace App\Components\Http404;

class Router extends \App\Lib\Router {
	protected function addRoutes(): void {
		$this->get("/", "get404");
	}
}