<?php
session_start();
if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off"){
    $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $redirect);
}
require_once './config.php';
require_once './functions.php';
require_once './db.php';
require_once './theme/header.php';
require_once './theme/content.php';
require_once './theme/footer.php';