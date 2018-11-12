<?php

class Route
{
  private $routes;

  public function __construct()
  {
    $routes = __DIR__ . '/../config/routes.php';
    if(file_exists($routes))
    {
      $this->routes = require_once $routes;
    }
    else
    {
      throw new Exception("Can't build Route object", 1);
    }
  }

  private function getRequestUri()
  {
    if(!empty($_SERVER['REQUEST_URI']))
    {
        return trim($_SERVER['REQUEST_URI'], '/');
    }
    return null;
  }

  public function run()
  {

    $uri = $this->getRequestUri();

    $routeExists = false;
    foreach ($this->routes as $pattern => $action)
    {
      if(preg_match("~$pattern~", $uri))
      {
        $innerRoute = preg_replace("~$pattern~", $action, $uri);
        $innerRouteParts = explode('/', $innerRoute);
        $controllerName = ucfirst(array_shift($innerRouteParts)) . 'Controller';
        $controller = new $controllerName();

        $action = 'action' . ucfirst(array_shift($innerRouteParts));

        $params = $innerRouteParts;
        $result = call_user_func_array([$controller, $action], $params);
        $routeExists = true;
        if($result !== false)
        {
          break;
        }

      }
    }
    if(!$routeExists)
    {
      $controller = new Page404Controller();
      $controller->showPage404();
    }



  }
}

 ?>
