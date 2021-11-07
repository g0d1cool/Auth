<?php
session_start();

ob_start();

if(isset($_SESSION['IsAuth']) && $_COOKIE['Token']){
    require_once 'tmp/main.php';
    exit();
}

if (isset($_GET['mode'])){
    switch ($_GET['mode']) {
    case 'auth':
        require_once 'tmp/auth-login.html';
        break;
    
    case 'reg':
        require_once 'tmp/auth-register.html';
        break;
    case 'main':
        require_once 'tmp/main.php';
        break;
    default:
    require_once 'tmp/auth-login.html';
        break;
    }
}
else
    require_once 'tmp/auth-login.html';
