<?php
class myFunctions {
    private static $instance = null;
    private $registry;

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

    private function __construct($registry) {
        $this->registry = $registry;        
    }

    public function validateDate($date, $format = 'Y-m-d H:i:s'){
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    public function printMessage($message, $level = 'info'){
        echo '
            <div class="alert alert-'.$level.' alert-dismissible fade in" role="alert" onclick="$(this).slideUp(\'fast\')" style="cursor:pointer">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                '.htmlentities($message).'
            </div>
        ';
    }

    public function getAgeFromBday($birthDate){
        if($birthDate != null){
            $birthDate = explode("-", $birthDate);
            $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[1], $birthDate[2], $birthDate[0]))) > date("md")
                    ? ((date("Y") - $birthDate[0]) - 1)
                    : (date("Y") - $birthDate[0]));

            return $age;
        }else return null;
    }

    public function checkUploadFile($file, $extensions, $types, $size){
        switch($file['error']){
            case UPLOAD_ERR_OK:{
                //check type
                if(!in_array($file['type'], $types)){
                    return 'Type d image incorrect.';
                }        
                //check extension
                $path_parts = pathinfo($file['name']);
                $extension = $path_parts['extension'];
                if(!in_array(strtolower($extension), $extensions)){
                    return 'Extension incorrect.';
                }
                //check size
                if($file['size'] > $size){
                    return 'Fichier trop grand. Taille maximum autorisée: '.$this->formatBytes($size);   
                }

                return true;
            }
            case UPLOAD_ERR_INI_SIZE: {
                return 'La taille du fichier téléchargé excède la valeur de upload_max_filesize, configurée dans le php.ini.';
            }
            case UPLOAD_ERR_FORM_SIZE: {
                return "La taille du fichier téléchargé excède la valeur de MAX_FILE_SIZE, qui a été spécifiée dans le formulaire HTML.";
            }
            case UPLOAD_ERR_PARTIAL: {
                return "Le fichier n'a été que partiellement téléchargé.";
            }
            case UPLOAD_ERR_NO_FILE: {
                return "Aucun fichier n'a été téléchargé.";
            }
            case UPLOAD_ERR_NO_TMP_DIR: {
                return "Un dossier temporaire est manquant. Introduit en PHP 5.0.3.";
            }
            case UPLOAD_ERR_CANT_WRITE: {
                return "Échec de l'écriture du fichier sur le disque. Introduit en PHP 5.1.0.";
            }
            case UPLOAD_ERR_EXTENSION: {
                return "Une extension PHP a arrêté l'envoi de fichier. PHP ne propose aucun moyen de déterminer quelle extension est en cause. L'examen du phpinfo() peut aider. Introduit en PHP 5.2.0.";
            }
            default: return false;
        }
    }

    public function formatBytes($size, $precision = 2){
        $base = log($size, 1024);
        $suffixes = ['', 'k', 'M', 'G', 'T'];

        return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];

    }
}