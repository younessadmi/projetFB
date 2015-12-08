<?php
class adminController{

    private $registry;
    
    public function __construct($registry){
        $this->registry = $registry;
    }
    
    public function index() {
        $this->registry->template->show('admin');
    }
}
?>