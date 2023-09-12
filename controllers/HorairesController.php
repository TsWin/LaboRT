<?php 
set_include_path($_SERVER['DOCUMENT_ROOT'].'/controllers/');
require_once 'DBController.php';

function getcreneau() {
    $Horaires = getHoraires();
    $creneau_l = [];
    foreach ($Horaires as $horaire) {
        $creneau_1->idcreneau = $horaire['idcreneau'];
        $creneau_1->datedebut = $horaire['datedebut'];
        $creneau_1->datefin = $horaire['datefin'];
        $creneau_1->description = $horaire['description'];
    }
    return $creneau_l;
}

function getHoraires() {
    $connex = connectDB();
    $sql = "SELECT * FROM creneau";
    $result = $connex->prepare($sql);
    $result->execute();
    $horaires = $result->fetchAll();
    return $horaires;
}

function getHoraire($id) {
    $connex = connectDB();
    $sql = "SELECT * FROM creneau WHERE idcreneau = $id";
    $result = $connex->prepare($sql);
    $result->execute();
    $horaire = $result->fetch();
    return $horaire;
}

function getDayOfWeek($date) {
    $timestamp = strtotime($date);
    $dayOfWeek = date('l', $timestamp);
    $dayOfWeekFr = '';
    switch ($dayOfWeek) {
        case 'Monday':
            $dayOfWeekFr = 'Lundi';
            break;
        case 'Tuesday':
            $dayOfWeekFr = 'Mardi';
            break;
        case 'Wednesday':
            $dayOfWeekFr = 'Mercredi';
            break;
        case 'Thursday':
            $dayOfWeekFr = 'Jeudi';
            break;
        case 'Friday':
            $dayOfWeekFr = 'Vendredi';
            break;
        case 'Saturday':
            $dayOfWeekFr = 'Samedi';
            break;
        case 'Sunday':
            $dayOfWeekFr = 'Dimanche';
            break;
        default:
            $dayOfWeekFr = '';
            break;
    }
    return $dayOfWeekFr;
  }

function isDateDuringCurrentWeekOrLater($date) {
    date_default_timezone_set('Europe/Paris');
    if (date('N') === '1') {
        $currentWeekStart = strtotime('today 00:00:00');
    } else {
        $currentWeekStart = strtotime('last Monday 00:00:00');
    }
    $currentWeekEnd = strtotime('next Sunday 23:59:59');
    $timestamp = strtotime($date);
    if ($timestamp >= $currentWeekStart && $timestamp <= $currentWeekEnd) {
        return true;
    } else {
        return false;
    }
}

function getDateOfCurrentDay() {
    $currentDay = date('Y-m-d');
    return $currentDay;
}

function timetostr($dateString) {
    $dateString = date('Y-m-d H:i:s', $dateString);
    return $dateString;
}

function createHoraire($datedebut, $datefin, $description) {
    $connex = connectDB();
    $sql = "INSERT INTO creneau (datedebut, datefin, description) VALUES (:datedebut, :datefin, :description)";
    $result = $connex->prepare($sql);
    $result->bindParam(':datedebut', $datedebut);
    $result->bindParam(':datefin', $datefin);
    $result->bindParam(':description', $description);
    $result->execute();
    if ($result->errorInfo())
        return $result->errorInfo()[2];
    else
        return null;
}

function deleteHoraire($id) {
    $connex = connectDB();
    $sql = "DELETE FROM creneau WHERE idcreneau = :id";
    $result = $connex->prepare($sql);
    $result->bindParam(':id', $id);
    $result->execute();
}
?>