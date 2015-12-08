<?php

#$config['base_url'] = 'http://projetfb.local/'; #en local
#$config['base_url'] = 'http://projetfb.local:8888/'; #en local MAC
$config['base_url'] = 'https://investigator.herokuapp.com/'; #en prod
$config['app_title'] = 'Quizz concours';
$config['app_version']  = '';
$config['logDirectory'] = DIRECTORY_SEPARATOR.'logs'.DIRECTORY_SEPARATOR;
$config['mail_webmaster'] = "younes.sadmi@valeo.com";

$fb['APP_ID'] = '1703275343238189';
$fb['APP_SECRET'] = '76b26f15d1178e8a081755edca60c8fc';
$fb['GRAPH_VERSION'] = 'v2.5';

$db['dbname'] = 'dfelp7mc51nf99' ;
$db['dbhost'] = 'ec2-54-228-180-92.eu-west-1.compute.amazonaws.com' ;
$db['dbport'] = '5432' ;
$db['dbtype'] = 'pgsql' ;
$db['dbuser'] = 'edkfohpdlgpukn' ;
$db['dbpassword'] = 'kcJ48ox4lfYRQi8kmDKJUkRK_g' ;
?>