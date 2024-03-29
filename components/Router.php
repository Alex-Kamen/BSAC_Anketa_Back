<?php

class Router {

	private $routes;

	public function __construct() {
		$routesPath = ROOT.'/config/routes.php';
		$this->routes = include($routesPath);
	}

	private function getURI() {
		if(!empty($_SERVER['REQUEST_URI'])) {
			if (stripos($_SERVER['REQUEST_URI'], '?')) {
				return stristr(trim($_SERVER['REQUEST_URI'], '/'), '?', true);
			}

			return trim($_SERVER['REQUEST_URI'], '/');
		}
	}

	public function run() {

		$uri = $this->getURI();

		foreach ($this->routes as $uriPattern => $path) {
			if($uri != "" && $uriPattern == "") {
				header("Location: /");
			}

			if(preg_match("~$uriPattern~", $uri)) {
				$internalRoute = preg_replace("~$uriPattern~", $path, $uri);
				$segments = explode("/", $internalRoute);

				$controllerName = ucfirst(array_shift($segments)."Controller");
				$actionName = "action".ucfirst(array_shift($segments));
				$parameters = $segments;

				$controllerFile = ROOT."/controllers/".$controllerName.'.php';
				if(file_exists($controllerFile)) {
					require_once($controllerFile);
				}

				$controllerObject = new $controllerName;
				$result = call_user_func_array(array($controllerObject, $actionName), $parameters);
				
				if($result != null) {
					break;
				}
			}
		}

	}

}