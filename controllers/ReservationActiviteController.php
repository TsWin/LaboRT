<?php 
set_include_path($_SERVER['DOCUMENT_ROOT'].'/');
require_once 'DBController.php';
require_once 'controllers/UserController.php';

function Create_Reservation($date, $durée, $description, $nombreetu) {
    $connex = connectDB();
    $idetu=0;
    $user = getUserWithToken($_COOKIE['token']);
    $login = $user['login'];
    $idetu = $user['idetu'];
    $datedebut = $date . ' ' . substr($durée,0,5);
    $datefin = $date . ' ' . substr($durée,6,11);
    $nb=0;
    $sql = "SELECT idresa FROM reservationactivite ORDER BY idresa DESC LIMIT 1";
    $result = $connex->prepare($sql);
    $result->execute();
    $nb_key= $result->fetchAll();
    if (empty($nb_key)) {
        $nb = 1;
    }
    else {
        foreach ($nb_key as $key => $value) {
            $nb = $value['idresa'] + 1;
        }
    }
    $nb= pg_escape_string($nb);
    $nb= filtreEntier($nb);
    $idetu= pg_escape_string($idetu);
    $idetu= filtreEntier($idetu);
    $datedebut= pg_escape_string($datedebut);
    $datefin= pg_escape_string($datefin);
    $description= pg_escape_string($description);
    $nombreetu= pg_escape_string($nombreetu);
    $nombreetu= filtreEntier($nombreetu);
    $regex1="@^\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}(:\d{2})?$@";
    if (preg_match_all($regex1, $datedebut, $resultats)){
        if (preg_match_all($regex1, $datefin, $resultats)){
                $sql = "INSERT INTO reservationactivite (idresa, idrefetu, datedebut, datefin, description, nombreetu) VALUES (:idresa, :idrefetu, :datedebut, :datefin, :description, :nombreetu);";
                $result = $connex->prepare($sql);
                $result->bindParam(':idresa', $nb);
                $result->bindParam(':idrefetu', $idetu);
                $result->bindParam(':datedebut', $datedebut);
                $result->bindParam(':datefin', $datefin);
                $result->bindParam(':description', $description);
                $result->bindParam(':nombreetu', $nombreetu);
                $result->execute();
        }
    }
    return $login;
}

function filtreEntier ($entree) {
// etape préalable 1 : traitement chaine mal formatée
    $entree=pg_escape_string($entree);
    settype($entree, "integer"); 
    return $entree; // retourne le résultat
}

function getHourAvaliable_1h(){
    $connex = connectDB();
    $sql = "SELECT * date FROM creneau";
    $result = $connex->prepare($sql);
    $result->execute();
    $dates = $result->fetchAll();
    $dateAvaliable = array();
    $datedebut= array();
    $datefin= array();
    foreach ($dates as $key => $value) {
        $datedebut = $value['datedebut'];
        $datefin = $value['datefin'];
        $dateAvaliable = array_merge($dateAvaliable, getHourinterval_1hour($datedebut, $datefin));
    }
    return $dateAvaliable;
}

function getHourAvaliable_2h(){
    $connex = connectDB();
    $sql = "SELECT * date FROM creneau";
    $result = $connex->prepare($sql);
    $result->execute();
    $dates = $result->fetchAll();
    $dateAvaliable = array();
    $datedebut=array();
    $datefin=array();
    foreach ($dates as $key => $value) {
        $datedebut = $value['datedebut'];
        $datefin = $value['datefin'];
        $dateAvaliable = array_merge($dateAvaliable, getHourinterval_2hour($datedebut, $datefin));
    }
    return $dateAvaliable;
}

function getHourinterval_1hour($datedebut, $datefin){
    $dateAvaliable = array();
    $date = $datedebut;
    while ($date < $datefin) {
        $dateAvaliable = array_merge($dateAvaliable, $date);
        $date = date('Y-m-d H:i:s', strtotime($date . ' + 30 minutes'));
    }
    if ($dateAvaliable[count($dateAvaliable)-1] - $date == "01:00:00") {
        return $dateAvaliable[0] . ' - ' . $dateAvaliable[count($dateAvaliable)-1];
    }
}

function getHourinterval_2hour($datedebut, $datefin){
    $dateAvaliable = array();
    $date = $datedebut;
    while ($date < $datefin) {
        $dateAvaliable = array_merge($dateAvaliable, $date);
        $date = date('Y-m-d H:i:s', strtotime($date . ' + 30 minutes'));
    }
    if ($dateAvaliable[count($dateAvaliable)-1] - $date == "02:00:00") {
        return $dateAvaliable[0] . ' - ' . $dateAvaliable[count($dateAvaliable)-1];
    }
}

function getReservationActivite(){
    $connex = connectDB();
    $sql = "SELECT * FROM reservationactivite";
    $result = $connex->prepare($sql);
    $result->execute();
    $reservations = $result->fetchAll();
    return $reservations;
}

function deleteReservation($idresa){
    $connex = connectDB();
    $sql = "DELETE FROM reservationactivite WHERE idresa = :idresa";
    $result = $connex->prepare($sql);
    $result->bindParam(':idresa', $idresa);
    $result->execute();
}
?>