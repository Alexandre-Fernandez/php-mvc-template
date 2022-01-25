<?php declare(strict_types=1);
namespace App;

class App {
	public const NAMESPACE = __NAMESPACE__;
	public const HOME_COMPONENT_NAME = "Home";
	public const HTTP_404_COMPONENT_NAME = "Http404";
	private const COMPONENTS_NAMESPACE = "Components";
	private const ROUTER_CLASS_NAME = "Router";

	public static function run() {
		self::getRouter();
	}

	/**
	 * @return object Router object corresponding to the current $_SERVER["REQUEST_URI"]
	 */
	private static function getRouter() {
		// getting component name
		$uri = $_SERVER["REQUEST_URI"] ?? "/";
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
		return new $router($namespace, $relativeRouting);
	}
}