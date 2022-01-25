<?php declare(strict_types=1);
namespace App\Components\Http404;

class Controller extends \App\Controller {
	public function get404() {
		$this->render("404", "main", ["title" => "404"]);
	}
}