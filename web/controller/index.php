<?php
class indexController extends baseController {

    public function index() {
        $this->registry->template->quizz = $this->registry->db->getInfoQuizz();
        $this->registry->template->show('index');
    }
}
?>