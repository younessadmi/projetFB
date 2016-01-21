<?php
class DB {
    private static $instance = null;
    private $registry;
    private $connexion = null;

    public static function getInstance($arg) {
        if (!self::$instance instanceof self) {
            self::$instance = new self($arg);
        }
        return self::$instance;
    }

    public function __clone() {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }

    public function __wakeup() {
        trigger_error('Deserializing is not allowed.', E_USER_ERROR);
    }

    public function getLastError(){
        $a = $this->connexion->errorInfo();
        return $a[2];
    }

    private function __construct($registry) {
        $this->registry = $registry;
        try
        {
            $this->connexion = new PDO(DB_TYPE.":host=".DB_HOST.";port=".DB_PORT.";dbname=".DB_NAME, DB_USER, DB_PASSWORD);
        }catch(PDOException $e)
        {
            print "Error new PDO: ".$e->getMessage()."<br/>";
            die();
        }
    }

    public function addQuizz($quizzName, $startDate, $endDate, $nbQuestionsTotal, $nbQuestionsDisplayed){
        if($query = $this->connexion->prepare('SELECT COUNT(*) AS nb FROM quizz WHERE name=?')){
            if($query->execute(array($quizzName))){
                if($query = $query->fetch()){
                    if($query['nb'] == 0){
                        $query2 = $this->connexion->prepare('
                            INSERT INTO quizz (name, date_start, date_end, questions_nb_total, questions_nb_displayed)
                            VALUES(?, ?, ?, ?, ?);
                        ');
                        if($query2->execute(array($quizzName, $startDate, $endDate, $nbQuestionsTotal, $nbQuestionsDisplayed))){
                            return true;
                        }else return 'Insertion has been not successful';
                    }else return 'The quizz name already exists';
                }else return 'Fetch failed';
            }else return 'Execute for existing quizz has failed';
        }else return 'Looking for existing quizz has failed';
    }

    public function getIdQuizzByName($quizzName){
        $query = $this->connexion->prepare('SELECT id FROM quizz WHERE name=?');
        if($query->execute(array($quizzName))){
            if($query->rowCount() == 1){
                $query = $query->fetch();
                return $query['id'];
            }else return false;
        }else return false;
    }

    public function addQuestion($idQuizz, $question, $rightAnswer, $wrongAnswer){
        //insertion de la question
        $query = $this->connexion->prepare('INSERT INTO question(label, id_quizz) VALUES(?, ?)');
        if($query->execute(array($question, $idQuizz))){
            //insertion des mauvaises propositions
            $idQuestion = $this->connexion->lastInsertId('question_id_seq'); //PURE DELIRE !!!!!!!!!!!!! Explication: table_colonne_seq et il faut vraiment écrire "seq"


            $idWrongAnswer = [];
            foreach($wrongAnswer as $answer){
                $query = $this->connexion->prepare('INSERT INTO proposition(label) VALUES(?)');
                if($query->execute(array($answer))){
                    $idWrongAnswer[] = $this->connexion->lastInsertId('proposition_id_seq');
                }else return 'error2: '.$this->getLastError();
            }
            //insertion de la bonne réponse
            $query = $this->connexion->prepare('INSERT INTO proposition(label) VALUES(?)');
            if($query->execute(array($rightAnswer))){
                $idRightAnswer = $this->connexion->lastInsertId('proposition_id_seq');
            }else return 'error6: '.$this->getLastError();
            //relations entres les questions et propositions
            //mauvaises réponses
            foreach($idWrongAnswer as $idAnswer){
                $query = $this->connexion->prepare('INSERT INTO answer(id_question, id_proposition, is_correct) VALUES(?, ?, 0)') or die('eerrorr');
                if($query->execute(array($idQuestion, $idAnswer))){

                }else return 'error3: '.$this->getLastError();
            }
            //bonne réponse
            $query = $this->connexion->prepare('INSERT INTO answer(id_question, id_proposition, is_correct) VALUES(?, ?, 1)') or die('eerrorr');
            if($query->execute(array($idQuestion, $idRightAnswer))){
                return true;
            }else return 'error4: '.$this->getLastError();



        }else return 'error1: '.$this->getLastError();

    }

    public function toggleQuizzEnabled($idQuizz){
        $query = $this->connexion->prepare('SELECT enabled FROM quizz WHERE id=?');
        $toEnabled = $this->connexion->prepare('UPDATE quizz SET enabled=1 WHERE id=?');
        $toDisabled = $this->connexion->prepare('UPDATE quizz SET enabled=0 WHERE id=?');
        if($query->execute(array($idQuizz))){
            $query = $query->fetch(PDO::FETCH_ASSOC);
            if($query['enabled']){
                return $toDisabled->execute(array($idQuizz));
            }else return $toEnabled->execute(array($idQuizz));
        }else return false;
    }

    public function getQuizz($idQuizz = 'ALL'){
        $sql = 'SELECT * FROM quizz '.(($idQuizz == 'ALL')? ' ' : 'WHERE id = ?');
        $sql.= ' ORDER BY date_end DESC';
        $query = $this->connexion->prepare($sql);
        if($idQuizz == 'ALL'){
            if($query->execute()){
                $quizzs = [];
                while($quizz = $query->fetch(PDO::FETCH_ASSOC)){
                    $quizzs[$quizz['id']] = $quizz;
                }
            }else return $this->getLastError();
        }else{
            if($query->execute(array($idQuizz))){
                $quizzs = [];
                while($quizz = $query->fetch(PDO::FETCH_ASSOC)){
                    $quizzs[$quizz['id']] = $quizz;
                }
            }else return $this->getLastError();
        }
        return $quizzs;
    }
}