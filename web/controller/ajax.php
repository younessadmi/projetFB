<?php
class ajaxController extends baseController {

    public function index() {        
        $this->registry->template->show('not_found');
    }

    public function updateQuestion(){
        if(isset($_POST['idQuestion']) && isset($_POST['idPropositions'])){
            $json_data = [
                'idQuestion' => [],
                'idPropositions' => []
            ];

            foreach($_POST['idQuestion'] as $id => $label){
                $json_data['idQuestion'][] = $this->registry->db->updateLabel($id, $label, 'question');
            }

            foreach($_POST['idPropositions'] as $id => $label){
                $json_data['idPropositions'][] = $this->registry->db->updateLabel($id, $label, 'proposition');
            }

            echo json_encode($json_data);
        }
    }

    public function getQuizzById(){
        if(isset($_POST['id']) && filter_var($_POST['id'], FILTER_VALIDATE_INT)){
            $idQuizz = $_POST['id'];
            $json_data['quizz'] = $this->registry->db->getQuestionsByIdQuizz($_POST['id']);
        }else $json_data['error'] = "Erreur d'id";   
        
        echo json_encode($json_data);
    }
}
?>