<?php declare(strict_types=1);
namespace App\Lib;

abstract class Controller {
	private ?object $model = null;
	private string $views;
	private string $layouts;

	public function __construct(
		string $namespace, 
		string $layoutsDir, 
		string $viewsDirName, 
		string $modelClassName
	) {
		$model = "$namespace\\" . $modelClassName;
		if(class_exists($model)) $this->model = new $model(\App\Database::getPdo());
		$controllerPath = explode( // one dir per index, last index is the instanciated .php controller
			DIRECTORY_SEPARATOR, (new \ReflectionClass($this))->getFileName()
		);
		$this->views = implode("/", array_slice($controllerPath, 0, -1)) . "/" . $viewsDirName;
		$this->layouts = $layoutsDir;
	}

	protected function callModel(string $modelMethod, array $params = []): mixed {
		if(!$this->model) throw new \Exception("Model not found");
		return call_user_func_array([$this->model, $modelMethod], $params);
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