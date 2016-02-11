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
//        $this->registry->fb->addPermission('manage_pages');
        $this->registry->fb->addPermission('publish_pages');
        
        //si on valide l'étape 1
        $toPostStep1 = ['quizz-name', 'quizz-nbQuestions', 'quizz-nbQuestionsDisplayed', 'quizz-lot', 'quizz-description', 'quizz-start-datetime', 'quizz-end-datetime', 'submit'];
        if(isset($_POST['submit'])){ // si le formulaire a été soumis
            if(array_keys($_POST) == $toPostStep1){ // si le formulaire envoie bien ce que l'on attend
                if(is_numeric($_POST['quizz-nbQuestions']) && $_POST['quizz-nbQuestions'] > 0 && $_POST['quizz-nbQuestions'] <= 30){
                    $checkUpload = $this->registry->myFunctions->checkUploadFile($_FILES['quizz-image'], ['jpg', 'jpeg', 'png'], ['image/jpeg', 'image/jpeg', 'image/png'], 1*1024*1024);
                    if($checkUpload === true){
                        if(is_numeric($_POST['quizz-nbQuestionsDisplayed']) && $_POST['quizz-nbQuestionsDisplayed'] > 0 && $_POST['quizz-nbQuestionsDisplayed'] <= $_POST['quizz-nbQuestions']){
                            if(!empty(trim($_POST['quizz-name']))){ // si le nom du quizz n'est pas vide
                                if(!empty(trim($_POST['quizz-lot']))){ // si le nom du quizz n'est pas vide
                                    if($this->registry->myFunctions->validateDate($_POST['quizz-start-datetime'], 'd/m/Y H:i')){ //si la date de début est valide
                                        if($this->registry->myFunctions->validateDate($_POST['quizz-end-datetime'], 'd/m/Y H:i')){ //si la date de fin est valide
                                            $startDate = DateTime::createFromFormat('d/m/Y H:i', $_POST['quizz-start-datetime']);
                                            $endDate = DateTime::createFromFormat('d/m/Y H:i', $_POST['quizz-end-datetime']);
                                            if($startDate->getTimestamp() < $endDate->getTimestamp()){ //si la date de début est avant la date de fin
                                                $filename = htmlentities(substr(date('Y-m-d_H-i-s').'__'.$_FILES['quizz-image']['name'], 0, 100));
                                                if(($uploadImageQuizz = $this->registry->fb->uploadImageQuizz($_FILES['quizz-image'], 'Venez découvrir le quizz : '.trim($_POST['quizz-name']).' - Disponible de '.$startDate->format('d/m/Y H:i:s').' au '.$endDate->format('d/m/Y H:i:s'))) !== false){
                                                    if(($res = $this->registry->db->addQuizz($_POST['quizz-name'], $startDate->format('Y-m-d H:i:s'), $endDate->format('Y-m-d H:i:s'), $_POST['quizz-nbQuestions'], $_POST['quizz-nbQuestionsDisplayed'], $uploadImageQuizz, $_POST['quizz-lot'], $_POST['quizz-description'])) === true){
                                                        $this->registry->template->idQuizz = $this->registry->db->getIdQuizzByName($_POST['quizz-name']);
                                                        $this->registry->template->nbQuestions = $_POST['quizz-nbQuestions'];
                                                        $this->registry->template->show('admin/addQuizz-step2');
                                                        die();
                                                    }else $this->registry->template->error = $res;
                                                }else $this->registry->template->error = 'Erreur move upload';
                                            }else $this->registry->template->error = 'La date de début est après la date de fin';
                                        }else $this->registry->template->error = 'La date de fin est fausse';
                                    }else $this->registry->template->error = 'La date de début est fausse';
                                }else $this->registry->template->error = 'Le nom du quizz est incorrect';
                            }else $this->registry->template->error = 'Le nom du quizz est incorrect';
                        }else $this->registry->template->error = 'Le nombre de questions est incorrect';
                    }else $this->registry->template->error = $checkUpload;
                }else $this->registry->template->error = 'Le nombre de questions est incorrect';
            }else $this->registry->template->error = 'Les clées POST ne sont pas celles attendues';
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
        $this->registry->template->quizz = $this->registry->db->getInfoQuizz();
        $this->registry->template->show('admin/listQuizz');
    }

    public function editQuizz($args){
        //si on édite le quizz
        if(isset($_POST['submit']) && $_POST['submit'] == 'update'){
            $post_expected = ['enabled', 'idquizz', 'name', 'original-name', 'description', 'lot', 'questions_nb_displayed', 'questions_nb_total', 'submit'];
            $post_expected2 = ['idquizz', 'name', 'original-name', 'description', 'lot', 'questions_nb_displayed', 'questions_nb_total', 'submit'];
            if($post_expected == array_keys($_POST) || $post_expected2 == array_keys($_POST)){
                if(is_numeric($_POST['idquizz'])){
                    if(strlen(trim($_POST['name'])) > 0){
                        if(is_numeric($_POST['questions_nb_displayed'])){
                            if($_POST['original-name'] == $_POST['name'] || $this->registry->db->checkQuizzNameExists($_POST['name']) === false){
                                if(($res = $this->registry->db->updateQuizz($_POST['idquizz'], $_POST['name'], null, null, ((isset($_POST['enabled']))? 1 : 0), $_POST['questions_nb_displayed'], null, $_POST['description'], $_POST['lot'])) === true){
                                    $this->registry->template->success = 'Le quizz a bien été mis à jour';
                                }else $this->registry->template->error = $res;
                            }else $this->registry->template->error = 'Nom de quizz déjà existant';
                        }else $this->registry->template->error = '';
                    }else $this->registry->template->error = 'Nom invalide';
                }else $this->registry->template->error = 'Erreur d\'identifiant';
            }else $this->registry->template->error = 'Erreur de formulaire';
        }

        //affichage par défaut
        if(isset($args[0]) && is_numeric($args[0])){
            if(!empty($quizz = $this->registry->db->getQuestionsByIdQuizz($args[0]))){
                $this->registry->template->quizz = $quizz;
                $this->registry->template->show('admin/editQuizz');
            }else $this->registry->template->show('not_found');
        }else $this->registry->template->show('not_found');
    }

    public function listUser(){
        $this->registry->template->players = $this->registry->db->getListPlayer();
        $this->registry->template->show('admin/listUser');
    }

}
?>