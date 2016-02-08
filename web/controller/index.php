<?php
class indexController extends baseController {

    public function index() {
        $quizz = $this->registry->db->getInfoQuizz();
        foreach($quizz as $quiz){
            $quizz[$quiz['id']]['isAbleToPlay'] = $this->registry->db->isAbleToPlay($this->registry->fb->getCurrentUserId(), $quiz['id']);
            $scores = $this->registry->db->getResultsByIdQuizz($quiz['id'], $this->registry->db->getUserIdByIdFb($this->registry->fb->getCurrentUserId()));
            foreach($scores as $score){
                $quizz[$quiz['id']]['score'] = $score['total'];
            }
        }
        $this->registry->template->quizz = $quizz;
        $this->registry->template->show('index');
    }
}
?>