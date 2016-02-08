<?php
class quizzController extends baseController {

    public function index(){        
        $this->registry->template->show('not_found');
    }

    public function play($args){
        if(isset($args[0]) && filter_var($args[0], FILTER_VALIDATE_INT)){
            $quizz = $this->registry->db->getInfoQuizz($args[0]);
            $this->registry->template->quizz = $quizz[$args[0]];
            $this->registry->template->idFb = $this->registry->fb->getCurrentUserId();
            $this->registry->template->show('quizz/play');
        }else $this->registry->template->show('not_found');
    }


}
?>