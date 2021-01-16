<?php


session_start();

$_SESSION['user_id'] = 1;

try{
    $db = new PDO('mysql:dbname=test;host=localhost','root','');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOExeption $e){
    echo "Connection failed : ". $e->getMessage();
}

if(!isset($_SESSION['user_id'])) {
    die('You are not signed in.');
}