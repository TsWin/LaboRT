<?php 
set_include_path($_SERVER['DOCUMENT_ROOT'].'/controllers/');
require_once 'DBController.php';

function isDatePast($date) {
    date_default_timezone_set('Europe/Paris');
    $currentdate = strtotime(date('Y-m-d'));
    $timestamp = strtotime($date);
    if ($timestamp < $currentdate) {
        return false;
    } else {
        return true;
    }
}

function getEvents() {
    $connex = connectDB();
    $sql = "SELECT * FROM events";
    $result = $connex->prepare($sql);
    $result->execute();
    $events = $result->fetchAll();
    return $events;
}

function createEvent($date, $nom, $description) {
    $connex = connectDB();
    $sql = "INSERT INTO events (date, nom, description) VALUES (:date, :nom, :description)";
    $result = $connex->prepare($sql);
    $result->bindParam(':nom', $nom);
    $result->bindParam(':date', $date);
    $result->bindParam(':description', $description);
    $result->execute();
}

function deleteEvent($id) {
    $connex = connectDB();
    $sql = "DELETE FROM events WHERE idevent = :id";
    $result = $connex->prepare($sql);
    $result->bindParam(':id', $id);
    $result->execute();
}
?>