<?php

namespace Core;

class Route
{
    private $routes;
    private $url;

    public function __construct(array $routes)
    {
        $this->routes = $routes;
        $this->setUrl();
        $this->run();
    }

    private function setUrl()
    {
        $this->url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    private function getUrl()
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    private function getRequest()
    {
        $obj = new \stdClass;

        foreach ($_GET as $key => $value) {
            $obj->get->$key = $value;
        }

        foreach ($_POST as $key => $value) {
            $obj->post->$key = $value;
        }

        return $obj;
    }

    private function getUrlParams()
    {
        $url = substr($this->url, 1, -1);
        $urlArray = explode('/', $url);
        $params = [];
        if (count($urlArray) >= 3) {
            for ($i = 2; $i < count($urlArray); $i++) {
                $params[] = $urlArray[$i];
            }
        }
        return $params;
    }

    private function getUrlWithoutParams()
    {
        if($this->url != '/'){
            $url = substr($this->url, 1, -1);
            if (strpos($url, '/')) {
                $urlArray = explode('/', $url);
                $treatUrl = "/" . $urlArray[0] . '/' . $urlArray[1] . '/';
            } else {
                $treatUrl = "/" . $url . "/";
            }
            return $treatUrl;
        }
        return "/";
    }

    private function findAndCheckRoute($urlWithoutParams, $urlParams)
    {
        foreach ($this->routes as $route) {
            if ($route['route'] == $urlWithoutParams) {
                if($route['params']){
                    if(count($route['params']) == count($urlParams)) {
                        for ($i = 0; $i < count($urlParams); $i++){
                            $route['params'][$i] = $urlParams[$i];
                        }
                        return $route;
                   } else{
                        return false;
                    }
                }
                return $route;
            }
        }
        return false;
    }

    private function run()
    {
        $urlWithoutParams = $this->getUrlWithoutParams();
        $urlParams = $this->getUrlParams();
        $route = $this->findAndCheckRoute($urlWithoutParams, $urlParams);
        if($route){
            $controller = $route['controller'];
            $action = $route['action'];
            $params = $route['params'];
            $nameSpace = "App\\Controllers\\{$controller}";
            $objController = new $nameSpace;
            if($params){
                $objController->$action($params);
            } else {
                $objController->$action();
            }
        } else {
            $homeController = new \App\Controllers\HomeController;
            $homeController->index();
        }


    }
}
