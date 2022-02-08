<?php declare(strict_types=1);
namespace App\Components\Http404;

class Router extends \App\Abstracts\Router {
	protected function addRoutes(): void {
		$this->get("/", "get404");
	}
}