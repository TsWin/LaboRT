<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
function connectDB() {
    $dsn='pgsql:host='.dbHost.';dbname='.dbName;
    try {
        $connex = new PDO($dsn, dbUser, dbPass);
    } catch (PDOException $e) {
        header('Location: '.errorURL.'4003');
        die("");
    }
    return $connex; 
}

function deconnectDB($connex) {
    $connex = null; 
}
?>