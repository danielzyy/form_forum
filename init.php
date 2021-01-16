<?php


try{
    $db = new PDO('pgsql:host=localhost;port=26257;dbname=defaultdb;sslmode=disable',
    'admin', null, array(
      PDO::ATTR_ERRMODE          => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_EMULATE_PREPARES => true,
      PDO::ATTR_PERSISTENT => true
    ));
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOExeption $e){
    echo "Connection failed : ". $e->getMessage();
}

// if(!isset($_SESSION['user_id'])) {
//     die('You are not signed in.');
// }