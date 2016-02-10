<?php

if($_SERVER['HTTP_HOST'] == 'projetfb.local'){
    DEFINE('BASE_URL', 'http://projetfb.local/');
    DEFINE('APP_ID', '1716084605290596');
    DEFINE('APP_ACCESS_TOKEN', '1716084605290596|IEI27ivzuFpkMiqalizBVa4zGsg');
    DEFINE('APP_SECRET', 'e2dde3f2ab37cbe332163624066d775f');
    DEFINE('APP_TITLE', 'TEST - Quizz concours');
}else{
    DEFINE('BASE_URL', 'https://investigator.herokuapp.com/');
    DEFINE('APP_SECRET', '76b26f15d1178e8a081755edca60c8fc');
    DEFINE('APP_ID', '1703275343238189');
    DEFINE('APP_ACCESS_TOKEN', '1703275343238189|hJJRUFOUgkNePNGKRb-aaf_lGxE');
    DEFINE('APP_TITLE', 'Quizz concours');
}

DEFINE('APP_VERSION', '');
DEFINE('LOG_DIRECTORY', DIRECTORY_SEPARATOR.'logs'.DIRECTORY_SEPARATOR);
DEFINE('MAIL_WEBMASTER', '');

DEFINE('GRAPH_VERSION', 'v2.5');
DEFINE('FAN_PAGE_ID', '1088711731169523');

DEFINE('DB_NAME', 'dfelp7mc51nf99');
DEFINE('DB_HOST', 'ec2-54-228-180-92.eu-west-1.compute.amazonaws.com');
DEFINE('DB_PORT', '5432');
DEFINE('DB_TYPE', 'pgsql');
DEFINE('DB_USER', 'edkfohpdlgpukn');
DEFINE('DB_PASSWORD', 'kcJ48ox4lfYRQi8kmDKJUkRK_g');

?>