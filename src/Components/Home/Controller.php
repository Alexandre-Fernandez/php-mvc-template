<?php declare(strict_types=1);
namespace App\Components\Home;

class Controller extends \App\Abstracts\Controller {
	public function getHome() {
		$this->render("home", "main", ["title" => "Home"]);
	}
}