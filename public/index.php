<?php declare(strict_types=1);
define("ROOT", str_replace("/public", "", __DIR__));
require ROOT . "/vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(ROOT);
$dotenv->load();


try {
	$router = getRouter();
}
catch (Exception $e) {
	http_response_code(404);
	echo "404 not found";
	exit();
}


/**
 * @return object Router object corresponding to the current $_SERVER["REQUEST_URI"]
 */
function getRouter(
	string $parentNamespace = "App", 
	string $componentsNamespace = "Components", 
	string $homeComponent = "Home", 
	string $routerClass = "Router"
): object {
	// getting component name
	$uri = $_SERVER["REQUEST_URI"] ?? "/";
	$uri = preg_split("/[\/.]/", strtolower($uri));
	$component = $homeComponent;
	if(!empty($uri[1]) && $uri[1] !== "index") {
		$uri[1][0] = strtoupper($uri[1][0]);
		$component = "$uri[1]";
	}
	// getting the component's router
	if($component === "404") throw new Exception("404 not found");
	$namespace = "\\$parentNamespace\\$componentsNamespace\\$component";
	$router = "$namespace\\$routerClass";
	if(!class_exists($router)) throw new Exception("$router doesn't exist");
	if($component === $homeComponent) return new $router($namespace, false);
	return new $router($namespace);
}