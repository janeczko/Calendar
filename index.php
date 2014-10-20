<?php

mb_internal_encoding('utf-8');

function classLoad($class)
{
    if (preg_match('/Controller$/', $class))
        require 'Controllers/' . $class . '.php';
    else
        require 'Models/' . $class . '.php';
}

spl_autoload_register('classLoad');

class Router
{
    protected $urlParameters;
    protected $controller;
    protected $action;

    public function __construct()
    {
        $this->urlParameters = [];
        $this->controller = null;
        $this->action = null;

        foreach ($_GET as $key => $value)
            $this->urlParameters[] = [$key => $value];
    }

    public function route()
    {
        /*
         * TODO - rewrite this method
         *
         * index.php with no parameters == login page with redirect to Home:index
         *
         * other options:
         *      first parameter - controller
         *      second parameter - action
         *      other parameters - parameters
         */

        if (isset($this->urlParameters[0]))
        {
            $name = str_replace(' ', '', ucwords(str_replace('-', ' ', key(array_shift($this->urlParameters))))) . 'Controller';
            $this->controller = new $name();

            if (!isset($this->urlParameters[0]))
            {
                $this->controller = new ErrorController();
                $this->controller->pageNotFound();
            }
            else
            {
                $this->action = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', key(array_shift($this->urlParameters)))))) . 'Action';
                $this->controller->setParameters($this->urlParameters);
                $this->controller->renderAction($this->action);
            }
        }
        else
        {
            $this->controller = new HomeController();
            $this->controller->renderAction('indexAction');
        }
    }
}

$router = new Router();
$router->route();
