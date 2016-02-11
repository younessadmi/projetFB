<?php
session_start();
require '../includes/facebook-php-sdk-v4-5.0.0/src/Facebook/autoload.php';
require '../conf/config.php';
$fb = new Facebook\Facebook([
    'app_id' => APP_ID,
    'app_secret' => APP_SECRET,
    'default_graph_version' => GRAPH_VERSION
]);

$helper = $fb->getRedirectLoginHelper();

try{
    $accessToken = $helper->getAccessToken();
}catch(Facebook\Exceptions\FacebookResponseException $e){
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
}catch(Facebook\Exceptions\FacebookSDKException $e){
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}

if(isset($accessToken)){
    // Logged in!
    $_SESSION['facebook_access_token'] = (string)$accessToken;

    // Now you can redirect to another page and use the
    // access token from $_SESSION['facebook_access_token']
//    header('Location: '.((isset($_SERVER['HTTP_REFERER']))? $_SERVER['HTTP_REFERER'] : BASE_URL));
    header('Location: '. BASE_URL);
}elseif ($error = $helper->getError()) {
    // The user denied the request
    echo $error;
    die();
}
?>