<?php declare(strict_types=1);
namespace App;

class App {
	public const NAMESPACE = __NAMESPACE__;
	public const LAYOUTS_DIR = __DIR__ . "/layouts";
	public const VIEWS_DIR_NAME = "views";
	public const COMPONENTS_NAMESPACE = "Components";
	public const HTTP_404_COMPONENT_NAME = "Http404";
	public const HOME_COMPONENT_NAME = "Home";
	public const MODEL_CLASS_NAME = "Model";
	public const CONTROLLER_CLASS_NAME = "Controller";
	public const ROUTER_CLASS_NAME = "Router";

	public static function run() {
		Database::init(
			$_ENV["DB_HOST"], 
			$_ENV["DB_NAME"], 
			$_ENV["DB_USER"], 
			$_ENV["DB_PASSWORD"]
		);
		self::getRouter($_SERVER["REQUEST_URI"] ?? "/")
		->run($_GET, $_POST);
	}

	/**
	 * @return object Router object corresponding to $uri
	 */
	private static function getRouter(string $uri): object {
		$uri = preg_split("/[\/.?]/", strtolower($uri));
		$relativeRouting = true;
		$components = self::NAMESPACE . "\\" . self::COMPONENTS_NAMESPACE . "\\";
		$component = $components;
		if(empty($uri[1]) || $uri[1] === "index") { // home component
			$relativeRouting = false;
			$component .= self::HOME_COMPONENT_NAME;
		}
		else { // other component (including 404)
			$uri[1][0] = strtoupper($uri[1][0]);
			$component .= $uri[1];
		}
		$router = "$component\\" . self::ROUTER_CLASS_NAME;
		if(!class_exists($router)) {
			$component = $components . self::HTTP_404_COMPONENT_NAME;
			$router = "$component\\" . self::ROUTER_CLASS_NAME;
			if(!class_exists($router)) { // echo if no 404 component 
				echo "Error 404: Page not found";
				exit();
			}
			return new $router($component, self::CONTROLLER_CLASS_NAME, $relativeRouting);
		}
		return new $router($component, self::CONTROLLER_CLASS_NAME, $relativeRouting);
	}
}