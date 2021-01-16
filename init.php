<?php


try{
    $db = new PDO('pgsql:host=free-tier.gcp-us-central1.cockroachlabs.cloud;port=26257;dbname=yellow-camel-256.defaultdb;sslmode=require;sslrootcert=cc-ca.crt',
    'user', 'userpassword', array(
      PDO::ATTR_ERRMODE          => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_EMULATE_PREPARES => true,
      PDO::ATTR_PERSISTENT => true
    ));
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOExeption $e){
    echo "Connection failed : ". $e->getMessage();
}