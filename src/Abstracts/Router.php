<?php declare(strict_types=1);
namespace App\Abstracts;

use AltoRouter;
use \App\App;

abstract class Router {
	private object $controller;
	private string $component;
	private bool $relativeRouting;
	private AltoRouter $router;

	/**
	 * @param  string $namespace path to the Router's namespace (e.g. \App\Users\Router -> \App\Users) 
	 * @param  string $relativeRouting if set to true, the routes will be relative to the namespace (e.g. \App\Users -> "localhost/users/$route")
	 * @param  string $controllerClass name of the Controller class in the namespace
	 */
	public function __construct(
		string $namespace, 
		string $controllerClassName, 
		bool $relativeRouting = true, 
		string $layoutsDir = App::LAYOUTS_DIR,
		string $viewsDirName = App::VIEWS_DIR_NAME, 
		string $modelClassName = App::MODEL_CLASS_NAME
	) {
		$controller = "$namespace\\" . $controllerClassName;
		if(!class_exists($controller)) throw new \Exception("$controller doesn't exist");
		$this->relativeRouting = $relativeRouting;
		$this->component = array_slice(explode("\\", $namespace,), -1)[0];
		$this->controller = new $controller($namespace, $layoutsDir, $viewsDirName, $modelClassName);
		$this->router = new AltoRouter();
		$this->addRoutes();
	}

	abstract protected function addRoutes(): void;

	public function run(array $query, array $body): void {
		$match = $this->router->match();
		if(is_array($match)) call_user_func($match["target"], [
			$match["params"], $query, $body
		]);
		else {
			header("location: /" . strtolower(\App\App::HTTP_404_COMPONENT_NAME)); 
			exit();
		}
	}

	protected function get(string $route, string $controllerMethod): self {
		return $this->addRoute("GET", $route, $controllerMethod);
	}

	protected function post(string $route, string $controllerMethod): self {
		return $this->addRoute("POST", $route, $controllerMethod);
	}

	protected function put(string $route, string $controllerMethod): self {
		return $this->addRoute("PUT", $route, $controllerMethod);
	}

	protected function delete(string $route, string $controllerMethod): self {
		return $this->addRoute("DELETE", $route, $controllerMethod);
	}

	private function addRoute(string $httpMethod, string $route, string $controllerMethod): self {
		if($this->relativeRouting) {
			$route = strtolower("/$this->component") . ($route === "/" ? "" : $route);
		}
		$this->router->map($httpMethod, $route, $this->callController($controllerMethod));
		return $this;
	}

	private function callController(string $controllerMethod): callable {
		return function(array $params = []) use($controllerMethod): void {
			call_user_func_array([$this->controller, $controllerMethod], $params);
		};
	}
}