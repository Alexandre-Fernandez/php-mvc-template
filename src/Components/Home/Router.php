<?php declare(strict_types=1);
namespace App\Components\Home;

class Router extends \App\Lib\Router {
	protected function init(): void {
		$this->get("/", "getHome");
	}
}