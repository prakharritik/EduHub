<?php
    /*$HOST = 'free-tier.gcp-us-central1.cockroachlabs.cloud';
    $PORT = 26257;
    $DB_NAME = 'thin-skunk-1724.defaultdb';
    $DB_USER = 'prakhar';
    $DB_PASSWORD = 'x06QPNIn2CL2LFVH';
    $pdo = new PDO(
        //"mysql:host=$HOST;port=$PORT;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD
        "pgsql:host=$HOST;port=$PORT;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);*/
     $HOST = 'sql6.freesqldatabase.com';
    $PORT = 3306;
    //$DB_NAME = 'education';
    //$DB_USER = 'root';
    //$DB_PASSWORD = '';
    $DB_NAME = 'sql6404852';
    $DB_USER = 'sql6404852';
    $DB_PASSWORD = 'DswZB9MfvN';
    $pdo = new PDO(
        "mysql:host=$HOST;port=$PORT;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD
        //"pgsql:host=$HOST;port=$PORT;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);