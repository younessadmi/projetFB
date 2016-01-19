<?php
class ajaxController extends baseController {

    public function index() {        
        $this->registry->template->show('not_found');
    }
}
?>