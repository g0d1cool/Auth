<?
session_start();
unset($_SESSION['IsAuth']);
unset($_SESSION['name']);
setcookie("Token", '', time()-3600*3, $_SERVER['DOCUMENT_ROOT']);
header('Location: ../');
?>