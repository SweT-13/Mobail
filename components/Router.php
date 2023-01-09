<?php


class Router
{
    private $routes;

    public function __construct()
    {
        $routesPath = ROOT . '/config/routes.php';
        $this->routes = include($routesPath);
    }

    /**s
     * return request string
     */
    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function run()
    {

        //получить строку запроса
        $uri = $this->getURI();

        //проверить наличие такого запроса
        foreach ($this->routes as $uriPattern => $path) {
            if (preg_match("~$uriPattern~", $uri)) {

                //Получение внутренего пути из внешнего
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);

                //Если есть совпадение определить controller и action
                $segments = explode('/', $internalRoute);

                //file
                $controllerName = array_shift($segments) . 'Controller';
                $controllerName = ucfirst($controllerName);
                //metod
                $actionName = 'action' . ucfirst(array_shift($segments));
                //parameters
                $parameters = $segments;

                //Подключить файл class-controller
                $controllerFile = ROOT . '/controllers/' . $controllerName . '.php';
                if (file_exists($controllerFile)) {
                    include_once($controllerFile);
                }

                //создать обьект, вызвать action
                $controllerObject = new $controllerName;
                //$result = $controllerObject->$actionName($parameters);
                $result = call_user_func_array(array($controllerObject, $actionName), $parameters);
                if ($result != null) {
                    break;
                }
            }
        }
    }
}