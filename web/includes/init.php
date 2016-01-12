<?php
include __SITE_PATH.DIRECTORY_SEPARATOR.'application'.DIRECTORY_SEPARATOR.'controller_base.class.php';
include __SITE_PATH.DIRECTORY_SEPARATOR.'application'.DIRECTORY_SEPARATOR.'registry.class.php';
include __SITE_PATH.DIRECTORY_SEPARATOR.'application'.DIRECTORY_SEPARATOR.'router.class.php';
include __SITE_PATH.DIRECTORY_SEPARATOR.'application'.DIRECTORY_SEPARATOR.'template.class.php';

function __autoload($class_name) {
    $filename = $class_name . '.class.php';
    $file = __SITE_PATH.DIRECTORY_SEPARATOR.'model'.DIRECTORY_SEPARATOR.$filename;

    if(file_exists($file) == false)
    {
        return false;
    }
    include ($file);
}

$registry = new registry;

$conf_file = __SITE_PATH.DIRECTORY_SEPARATOR.'conf'.DIRECTORY_SEPARATOR.'config.php';
if(file_exists($conf_file))
{
    include $conf_file;
}

$registry->myFunctions = myFunctions::getInstance($registry);
$registry->db = db::getInstance($registry);
$registry->fb = fb::getInstance($registry);
?>