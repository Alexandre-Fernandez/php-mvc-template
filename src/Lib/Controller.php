<?php declare(strict_types=1);
namespace App\Lib;

abstract class Controller {
	private ?string $model = null;
	private string $views;
	private string $layouts;

	public function __construct(
		string $namespace, 
		string $layoutsDir, 
		string $viewsDirName, 
		string $modelClassName
	) {
		$model = "$namespace\\" . $modelClassName;
		if(class_exists($model)) $this->model = $model;
		$controllerPath = explode( // one dir per index, last index is the instanciated .php controller
			DIRECTORY_SEPARATOR, (new \ReflectionClass($this))->getFileName()
		);
		$this->views = implode("/", array_slice($controllerPath, 0, -1)) . "/" . $viewsDirName;
		$this->layouts = $layoutsDir;
	}
	
	/**
	 * @param  string $model model namespace path, by default the one corresponding to the controller's component (when $model = null)
	 */
	protected function callModel(string $modelMethod, array $params = [], string $model = null): mixed {
		$pdo = \App\Database::getPdo();
		if($this->model) $model = new $this->model($pdo);
		else if(class_exists($model)) $model = new $model($pdo);
		else throw new \Exception("Model not found");
		return call_user_func_array([$model, $modelMethod], $params);
	}

	protected function render(string $view, string $layout = null, array $params = []) {
		extract($params);
		ob_start();
		require "$this->views/$view.html.php";
		$content = ob_get_clean();
		if(!$layout) {echo $content; return;}
		require "$this->layouts/$layout.html.php";
		exit();
	}

	protected function redirect(string $route): void {
		header("location: $route");
		exit();
	}
}