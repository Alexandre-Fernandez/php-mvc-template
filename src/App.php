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
		self::initDatabase(
			$_ENV["DB_HOST"], 
			$_ENV["DB_NAME"], 
			$_ENV["DB_USER"], 
			$_ENV["DB_PASSWORD"]
		);
		self::getRouter($_SERVER["REQUEST_URI"] ?? "/")
		->run($_GET, $_POST);
	}

	private static function initDatabase(
		string $hostname, 
		string $name, 
		string $username, 
		string $password
	) {
		Database::init($hostname, $name, $username, $password);
	}

	/**
	 * @return object Router object corresponding to $uri
	 */
	private static function getRouter(string $uri): object {
		// getting component name
		$uri = preg_split("/[\/.?]/", strtolower($uri));
		$component = self::HOME_COMPONENT_NAME;
		if(!empty($uri[1]) && $uri[1] !== "index") {
			$uri[1][0] = strtoupper($uri[1][0]);
			$component = "$uri[1]";
		}
		// getting the component's router
		$namespace = self::NAMESPACE . "\\" . self::COMPONENTS_NAMESPACE . "\\$component";
		$router = "$namespace\\" . self::ROUTER_CLASS_NAME;
		if(!class_exists($router)) {
			$namespace = self::NAMESPACE . "\\" . self::COMPONENTS_NAMESPACE . "\\" . self::HTTP_404_COMPONENT_NAME;
			$router = "$namespace\\" . self::ROUTER_CLASS_NAME;
		}
		$relativeRouting = !($component === self::HOME_COMPONENT_NAME);
		return new $router($namespace, self::CONTROLLER_CLASS_NAME, $relativeRouting);
	}
}