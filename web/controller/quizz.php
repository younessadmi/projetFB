<?php
class quizzController extends baseController {

    public function index(){        
        $this->registry->template->show('not_found');
    }

    public function play($args){
        if(isset($args[0]) && filter_var($args[0], FILTER_VALIDATE_INT)){
            $quizz = $this->registry->db->getInfoQuizz($args[0]);
            if(!empty($quizz[$args[0]])){
                $quizz = $quizz[$args[0]];
                if($quizz['enabled'] == 1){
                    $idFb = $this->registry->fb->getCurrentUserId();
                    $idPlayer = $this->registry->db->getUserIdByIdFb($idFb);
                    $this->registry->template->idFb = $idFb;
                    $results = $this->registry->db->getResultsByIdQuizz($args[0],$idPlayer);
                    if(strtotime($quizz['date_end']) > time() && empty($results)){
                        $this->registry->template->quizz = $quizz;
                        $this->registry->template->show('quizz/play');
                    }else header('Location: '.BASE_URL.'quizz/results/'.$args[0]);
                }else $this->registry->template->show('not_found');
            }else $this->registry->template->show('not_found');
        }else $this->registry->template->show('not_found');
    }

    public function results($args){
        if(isset($args[0]) && filter_var($args[0], FILTER_VALIDATE_INT)){
            $quizz = $this->registry->db->getInfoQuizz($args[0]);
            if(!empty($quizz)){
                $this->registry->template->quizz = $quizz[$args[0]];
                $idFb = $this->registry->fb->getCurrentUserId();
                $idPlayer = $this->registry->db->getUserIdByIdFb($idFb);
                $this->registry->template->idPlayer = $idPlayer;
                $this->registry->template->results = $this->registry->db->getResultsByIdQuizz($args[0]);
                $this->registry->template->myresults = $this->registry->db->getResultsByIdQuizz($args[0],$idPlayer);
                $myresults = $this->registry->db->getResultsByIdQuizz($args[0],$idPlayer);
                if(strtotime($quizz[$args[0]]['date_end'])>time() && empty($myresults)){
                    header('Location: '.BASE_URL.'quizz/play/'.$args[0]);
                }else $this->registry->template->show('quizz/results');
            }else $this->registry->template->show('not_found');
        }else $this->registry->template->show('not_found');
    }
}
?>