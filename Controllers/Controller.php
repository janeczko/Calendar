<?php

class Controller
{
    protected $parameters;
    protected $title;
    protected $renderData;
    protected $db;

    public function __construct()
    {
        $this->renderData = [];
        $this->db = null;   // TODO - Connect database
        $this->title = 'Kalendář';
    }

    public function initialize()
    {
        echo 'init';
    }

    public function renderView($view)
    {
        extract($this->renderData);
        $title = $this->title;

        require $this->viewPath($view);
    }

    protected function viewPath($view)
    {
        return 'Views/' . $view . '.phtml';
    }

    protected function redirect($url)
    {
        header('Location: ' . $url);
        header('Connection: close');
        exit;
    }

    public function pageNotFound()
    {
        $this->redirect('index.php?error&error');
    }

    public function renderAction($action)
    {
        $this->initialize();
        $this->$action();
    }

    public function setParameters($paremeters)
    {
        $this->parameters = $paremeters;
    }
} 