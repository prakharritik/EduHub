<?php
    
     $HOST = 'localhost';
    $PORT = 3306;
   
    $DB_NAME = getenv('host');
    $DB_USER = getenv('host');
    $DB_PASSWORD = getenv('pass');
    $pdo = new PDO(
        "mysql:host=$HOST;port=$PORT;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD
        //"pgsql:host=$HOST;port=$PORT;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
