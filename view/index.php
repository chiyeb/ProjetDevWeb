<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$url = $_SERVER['REQUEST_URI']; //test.fr/index.php?user/login

$clean_url = strtok($url,'?'); //user/login
$cut_url = explode('/',trim($clean_url,'/')); // user  login

$get_control_name = isset($cut_url[0]) ? ucfirst($cut_url[0]).'_controller': 'login';
$get_function = isset($cut_url[1]) ? ucfirst($cut_url[1]) : 'login';

$control_url = "control/{$get_control_name}.php";

if(file_exists($control_url)){
    require $control_url;

}
else{
    include('view/login.php');
}

?>