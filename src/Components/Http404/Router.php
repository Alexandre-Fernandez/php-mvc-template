<?php declare(strict_types=1);
namespace App\Components\Http404;

class Router extends \App\Router {
	protected function init(): void {
		$this->get("/", "get404")->run();
	}
}