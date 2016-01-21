<?php
class adminController{

    private $registry;

    public function __construct($registry){
        if(!$registry->is_admin){
            $registry->template->show('not_found');
            die();   
        }
        $this->registry = $registry;
    }

    public function index() {
        $this->registry->template->show('admin/admin');
    }

    public function addQuizz(){
        //si on valide l'étape 1
        $toPostStep1 = ['quizz-name', 'quizz-start-datetime', 'quizz-end-datetime', 'quizz-nbQuestions', 'quizz-nbQuestionsDisplayed', 'submit'];
        if(isset($_POST['submit'])){ // si le formulaire a été soumis
            if(array_keys($_POST) == $toPostStep1){ // si le formulaire envoie bien ce que l'on attend
                if(is_numeric($_POST['quizz-nbQuestions']) && $_POST['quizz-nbQuestions'] > 0 && $_POST['quizz-nbQuestions'] <= 30){
                    if(is_numeric($_POST['quizz-nbQuestionsDisplayed']) && $_POST['quizz-nbQuestionsDisplayed'] > 0 && $_POST['quizz-nbQuestionsDisplayed'] <= $_POST['quizz-nbQuestions']){
                        if(!empty(trim($_POST['quizz-name']))){ // si le nom du quizz n'est pas vide
                            if($this->registry->myFunctions->validateDate($_POST['quizz-start-datetime'], 'd/m/Y H:i')){ //si la date de début est valide
                                if($this->registry->myFunctions->validateDate($_POST['quizz-end-datetime'], 'd/m/Y H:i')){ //si la date de fin est valide
                                    $startDate = DateTime::createFromFormat('d/m/Y H:i', $_POST['quizz-start-datetime']);
                                    $endDate = DateTime::createFromFormat('d/m/Y H:i', $_POST['quizz-end-datetime']);
                                    if($startDate->getTimestamp() < $endDate->getTimestamp()){ //si la date de début est avant la date de fin
                                        if(($res = $this->registry->db->addQuizz($_POST['quizz-name'], $startDate->format('Y-m-d H:i:s'), $endDate->format('Y-m-d H:i:s'), $_POST['quizz-nbQuestions'], $_POST['quizz-nbQuestionsDisplayed'])) === true){
                                            //                                    $this->registry->template->success = 'Le quizz a été correctement ajouté ! ';
                                            $this->registry->template->idQuizz = $this->registry->db->getIdQuizzByName($_POST['quizz-name']);
                                            $this->registry->template->nbQuestions = $_POST['quizz-nbQuestions'];
                                            $this->registry->template->show('admin/addQuizz-step2');
                                            die();
                                        }else $this->registry->template->error = $res;
                                    }else $this->registry->template->error = 'The first date is later than the end date';
                                }else $this->registry->template->error = 'Second date is wrong';
                            }else $this->registry->template->error = 'First date is wrong';
                        }else $this->registry->template->error = 'The quizz name is empty';
                    }else $this->registry->template->error = 'Le nombre de questions est incorrect';
                }else $this->registry->template->error = 'Le nombre de questions est incorrect';
            }else $this->registry->template->error = 'Keys are not similar';
        }

        //si on valide l'étape 2
        if(isset($_POST['idQuizz'])){
            if(is_numeric($_POST['idQuizz']) && is_numeric($_POST['nbQuestions'])){
                $toReady = true;

                for($i=1; $i <= $_POST['nbQuestions']; $i++){
                    if(!(isset($_POST[$i.'__question']) && isset($_POST[$i.'__right-answer']) && isset($_POST[$i.'__right-answer']) && is_array($_POST[$i.'__wrong-answer']) && count($_POST[$i.'__wrong-answer']) == 3)){
                        $toReady = false;
                        break;
                    }
                }
                if($toReady){
                    $success = true;
                    for($i=1; $i <= $_POST['nbQuestions']; $i++){
                        if($this->registry->db->addQuestion($_POST['idQuizz'], $_POST[$i.'__question'], $_POST[$i.'__right-answer'], $_POST[$i.'__wrong-answer']) === true){

                        }else{
                            $success = false;
                            $this->registry->template->error = $this->registry->db->getLastError();
                            break;
                        }
                    }
                    if($this->registry->db->toggleQuizzEnabled($_POST['idQuizz'])){
                        $this->registry->template->success = 'Le quizz a été correctement ajouté !';
                    }else $this->registry->template->error = $this->registry->db->getLastError();
                }else{
                    $this->registry->template->error = 'Les champs ne sont pas tous complet';
                    $this->registry->template->idQuizz = $_POST['idQuizz'];
                    $this->registry->template->nbQuestions = $_POST['nbQuestions'];
                    $this->registry->template->show('admin/addQuizz-step2');
                }
            }else
            {
                $this->registry->template->error = 'L\'id quizz ou le nb de question sont chelou quand même';
                $this->registry->template->idQuizz = $_POST['idQuizz'];
                $this->registry->template->nbQuestions = $_POST['nbQuestions'];
                $this->registry->template->show('admin/addQuizz-step2');

            }
        }

        $this->registry->template->show('admin/addQuizz-step1');
    }
    
    public function listQuizz(){
        $this->registry->template->quizz = $this->registry->db->getQuizz();
        $this->registry->template->show('admin/listQuizz');
    }
}
?>