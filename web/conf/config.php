<?php

if($_SERVER['HTTP_HOST'] == 'projetfb.local'){
    DEFINE('BASE_URL', 'http://projetfb.local/');
}else DEFINE('BASE_URL', 'https://investigator.herokuapp.com/');

DEFINE('APP_TITLE', 'Quizz concours');
DEFINE('APP_VERSION', '');
DEFINE('LOG_DIRECTORY', DIRECTORY_SEPARATOR.'logs'.DIRECTORY_SEPARATOR);
DEFINE('MAIL_WEBMASTER', '');

DEFINE('APP_ID', '1703275343238189');
DEFINE('APP_SECRET', '76b26f15d1178e8a081755edca60c8fc');
DEFINE('GRAPH_VERSION', 'v2.5');

DEFINE('DB_NAME', 'dfelp7mc51nf99');
DEFINE('DB_HOST', 'ec2-54-228-180-92.eu-west-1.compute.amazonaws.com');
DEFINE('DB_PORT', '5432');
DEFINE('DB_TYPE', 'pgsql');
DEFINE('DB_USER', 'edkfohpdlgpukn');
DEFINE('DB_PASSWORD', 'kcJ48ox4lfYRQi8kmDKJUkRK_g');

?>