<?php
class FB {
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
            'app_id' => $registry->fb['APP_ID'],
            'app_secret' => $registry->fb['APP_SECRET'],
            'default_graph_version' => $registry->fb['GRAPH_VERSION'],
        ]);
        $this->registry = $registry;
    }

    public function get_roles(){
        //        $request = new FacebookRequest(
        //            $session,
        //            'GET',
        //            '/'.$this->registry->fb['APP_ID'].'/roles'
        //        );
        //
        //        $response = $request->execute();
        //        $graphObject = $response->getGraphObject();
        //        return $graphObject;
        //////////////////////
        $response = $this->fb->get('/'.$this->registry->fb['APP_ID'].'/roles');
        return $response->getGraphEdge()->asArray();        
    }

    public function is_admin($id_user){
        $admins = $this->get_roles();        
    }
}