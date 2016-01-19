<?php
class fb {
    private static $instance = null;
    private $registry;
    private $fb;

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
        require_once __SITE_PATH.'/includes/facebook-php-sdk-v4-5.0.0/src/Facebook/autoload.php';
        $this->fb = new Facebook\Facebook([
            'app_id' => APP_ID,
            'app_secret' => APP_SECRET,
            'default_graph_version' => GRAPH_VERSION
        ]);
        $this->fb->setDefaultAccessToken(APP_ACCESS_TOKEN);

        if(!$this->is_user_connected()){
            die('Not connected');
        }
        if(!$this->is_app_allowed()){
            die('Permission denied');
        }

        $this->registry = $registry;
    }

    private function is_user_connected(){
        return true;
        //on verra si on a besoin de checker la connexion ou pas
    }
    private function is_app_allowed(){
        return true;
    }

    public function get_roles(){
        $response = $this->fb->get('/'.APP_ID.'/roles');
        return $response->getGraphEdge()->asArray();
    }

    public function is_admin($id_user){
        $admins = $this->get_roles();
    }

    public function get_user_token(){

    }
}