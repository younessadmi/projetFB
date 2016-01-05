<?php
class router {
    private $registry;

    private $path;
    public $args = [];
    public $file;
    public $controller;
    public $action;

    function __construct($registry) {
        $this->registry = $registry;
    }

    function setPath($path){

        if (is_dir($path) == false)
        {
            throw new Exception ('Invalid controller path: `' . $path . '`');
        }

        $this->path = $path;
    }

    public function loader()
    {

        $this->getController();

        if (is_readable($this->file) == false)
        {
            $this->registry->template->show('not_found');
            die();
        }

        include $this->file;

        $class = $this->controller . 'Controller';
        $controller = new $class($this->registry);

        if (is_callable(array($controller, $this->action)) == false)
        {
            $action = 'index';
        }
        else
        {
            $action = $this->action;
        }

        $controller->$action($this->args);
    }

    private function getController() {

        $route = (empty($_GET['rt'])) ? '' : $_GET['rt'];

        if (empty($route))
        {
            $route = 'index';
        }
        else
        {

            $parts = explode('/', $route);
            $this->controller = $parts[0];
            array_shift($parts);
            if(isset( $parts[0]))
            {
                $this->action = $parts[0];
                array_shift($parts);
                if(is_array($parts))
                {
                    $this->args = $parts;
                }
            }
        }

        if (empty($this->controller))
        {
            $this->controller = 'index';
        }


        if (empty($this->action))
        {
            $this->action = 'index';
        }

        $this->file = $this->path.DIRECTORY_SEPARATOR.$this->controller.'.php';
    }
}