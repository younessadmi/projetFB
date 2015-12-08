<?php
Class template {

    private $registry;

    private $vars = [];

    function __construct($registry) {
        $this->registry = $registry;

    }

    public function __set($index, $value)
    {
        $this->vars[$index] = $value;
    }

    function show($name) {
        $header = __SITE_PATH.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'site_header.php';
        $footer = __SITE_PATH.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'site_footer.php';
        $path = __SITE_PATH.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.$name.'.php';
        if (file_exists($path) == false)
        {
            throw new Exception('Template not found in '. $path);
            return false;
        }
        $this->config = $this->registry->config;

        foreach ($this->vars as $key => $value)
        {
            $$key = $value;
        }
        include ($header);
        include ($path);
        include ($footer);
    }
}