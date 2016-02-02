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
        $birthDate = explode("-", $birthDate);
        $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[1], $birthDate[2], $birthDate[0]))) > date("md")
            ? ((date("Y") - $birthDate[0]) - 1)
            : (date("Y") - $birthDate[0]));

        return $age;
    }
}