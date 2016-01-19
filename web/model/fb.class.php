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

    private function __construct($registry){
        $permissions = ['email', 'user_likes'];
        require_once __SITE_PATH.'/includes/facebook-php-sdk-v4-5.0.0/src/Facebook/autoload.php';
        $fb = new Facebook\Facebook([
            'app_id' => APP_ID,
            'app_secret' => APP_SECRET,
            'default_graph_version' => GRAPH_VERSION
        ]);
        $helper = $fb->getRedirectLoginHelper();
        if(empty($_SESSION['facebook_access_token'])){
            $loginUrl = $helper->getLoginUrl(BASE_URL.'scripts/login.php', $permissions);
            header('Location: '.$loginUrl);
        }else{
            if($this->tokenIsValid()){
                $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);   
            }else{
                $loginUrl = $helper->getLoginUrl(BASE_URL.'scripts/login.php', $permissions);
                header('Location: '.$loginUrl);
            }
        }

        $this->fb = $fb;
        $registry->is_admin = $this->is_admin($this->getCurrentUserId());
        $this->registry = $registry;
    }

    private function tokenIsValid(){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://graph.facebook.com/me?access_token='.$_SESSION['facebook_access_token']);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $return = curl_exec($curl);
        $return = json_decode($return, true);
        curl_close($curl);
        return !isset($return['error']);
    }

    public function get_roles(){
        try{
            $response = $this->fb->get('/'.APP_ID.'/roles', APP_ACCESS_TOKEN);
        }catch(Facebook\Exceptions\FacebookResponseException $e){
            echo $e->getMessage();
            exit;
        }
        return $response->getGraphEdge()->asArray();
    }

    public function getCurrentUserId(){
        try{
            $response = $this->fb->get('/me')->getGraphUser()->AsArray();
        }catch(Facebook\Exceptions\FacebookResponseException $e){
            echo $e->getMessage();
            exit;
        }
        return $response['id'];
    }

    public function is_admin($id_user){
        $admins = $this->get_roles();
        foreach($admins as $admin){
            if($admin['role'] == 'administrators'){
                if($admin['user'] == $id_user){
                    return true;
                }
            }
        }
        return false;
    }

    public function get_user_token(){

    }
}