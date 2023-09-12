<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
require_once DIR_BASE.'./controllers/ReservationActiviteController.php';
$date = $_POST['date'];
$date = pg_escape_string($date);
$choix = $_POST['duration'];
if ($_POST['duration'] == 1) {
    $durée = $_POST['timeslot_1'];
    $durée = pg_escape_string($durée);
} else {
    $durée = $_POST['timeslot_2'];
    $durée = pg_escape_string($durée);
}
$description = $_POST['description'];
$description = pg_escape_string($description);
$nombreetu = $_POST['nombreetu'];
$nombreetu= filtreEntier($nombreetu);
$regex1="@^\d{4}-\d{2}-\d{2}$@";
$regex2="@^\d{2}:\d{2}-\d{2}:\d{2}$@";
$regex3="@^[^<>\&;]*$@";
$regex4="@^.{0,255}$@";
if (preg_match_all($regex1, $date, $resultats)){
    if (preg_match_all($regex2, $durée, $resultats)){
        if (preg_match_all($regex3, $description, $resultats)){
            if (preg_match_all($regex4, $description, $resultats)){
                $reservation = Create_Reservation($date, $durée, $description, $nombreetu);
            }
            else {
                $reservation = "4";
            }
            }
        else {
            $reservation = "3";
        }
        }
    else {
        $reservation = "2";
    }
}
else {
    $reservation = "1";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="5; URL=../pages/reservations.php">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/style.css" rel="stylesheet">
    <title>Réservation Confirmée</title>
    <favicon>
        <link rel="icon" type="image/png" href="../assets/img/Labo.png"/>
    </favicon>
</head>
<body class="background-gradient">
    <?php 
        include '../components/header.php';
        if ($reservation == "1"){
            echo "<main class='resa_done'>";
            echo "<h2>Erreur lors de la réservation !</h2>";
            echo "<p>La date n'est pas au bon format.</p>";
        }
        elseif ($reservation == "2"){
            echo "<main class='resa_done'>";
            echo "<h2>Erreur lors de la réservation !</h2>";
            echo "<p>Le créneau horaire n'est pas au bon format.</p>";
        }
        elseif ($reservation == "3"){
            echo "<main class='resa_done'>";
            echo "<h2>Erreur lors de la réservation !</h2>";
            echo "<p>La description n'est pas au bon format.</p>";
        }
        elseif ($reservation == "4"){
            echo "<main class='resa_done'>";
            echo "<h2>Erreur lors de la réservation !</h2>";
            echo "<p>La description est trop longue.</p>";
        }
        else {
            echo "<main class='resa_done'>";
            echo "<h2>Votre réservation a bien été prise en compte !</h2>";
            echo "<br>";
            echo "<p>Identifiant étudiant : $reservation</p>";
            echo "<p>Date : $date</p>";
            echo "<p>Durée : $choix heure(s)</p>";
            echo "<p>Créneau horaire : $durée</p>";
            echo "<p>Description : $description</p>";
            echo "<p>Nombre d'étudiants : $nombreetu</p>";
        }
        ?>
        <br>
        <h3>Vous allez être redirigé vers la page de réservation dans 5 secondes.</h3>
    </main>
    <?php 
        include '../components/footer.php';
    ?>
</body>
</html>
