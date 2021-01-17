<?php
try{
    $db = new PDO('pgsql:host=trusty-lemur-8c3.gcp-northamerica-northeast1.cockroachlabs.cloud;port=26257;dbname=danielye;sslmode=require;sslrootcert=trusty-lemur-ca.crt',
    'user', 'password1234', array(
      PDO::ATTR_ERRMODE          => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_EMULATE_PREPARES => true,
      PDO::ATTR_PERSISTENT => true
    ));
    // $db = new PDO('mysql:dbname=form_forum;host=localhost','root','');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOExeption $e){
    echo "Connection failed : ". $e->getMessage();
}