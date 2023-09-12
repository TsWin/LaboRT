<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
require_once DIR_BASE.'./controllers/ReservationActiviteController.php';
include_once DIR_BASE.'controllers/AuthController.php';
if(isset($_GET['ticket'])){
    login('reservations', $_GET['ticket'], false);
} else {
    login('reservations', null, false);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/style.css" rel="stylesheet">
    <title>LaboRT - Réservation</title>
    <script defer src="../assets/js/timeslots.js"></script>
    <favicon>
        <link rel="icon" type="image/png" href="../assets/img/Labo.png"/>
    </favicon>
</head>
<body class="background-gradient">
    <?php 
        require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
        require_once DIR_BASE.'./controllers/HorairesController.php';
        include_once '../components/headerAdmin.php';
    ?>
    <div class="landing" id="blocked">
        <div class="text-box" id="space-top">
            <div id="form">
                <h2>Réservation d'un créneau de travail</h2>
                <form method="POST" action="affiche_resa.php">
                    <?php
                    $day=getDateOfCurrentDay();
                    echo '<div class="element-form">';
                    echo '<label for="date">Date : </label>';
                    echo '<input type="date" name="date" min="'.$day.'" value="'.$day.'" pattern="^\d{4}-\d{2}-\d{2}$" required><br>';
                    echo '</div>';
                    ?>

                    <div class="element-form">
                        <label for="duration">Durée :</label>
                        <input id="duration_1" type="radio" name="duration" value="1" checked> 1 heure
                        <input id="duration_2" type="radio" name="duration" value="2"> 2 heures<br>
                    </div>

                    <div class="element-form">
                        <div id="timeslot_1">
                            <label for="timeslot_1">Créneau horaire (1 heure) :</label>
                            <select name="timeslot_1" required>
                                <option value="08:00-09:00">08:00 - 09:00</option>
                                <option value="09:00-10:00">09:00 - 10:00</option>
                                <option value="10:00-11:00">10:00 - 11:00</option>
                                <option value="11:00-12:00">11:00 - 12:00</option>
                                <option value="12:00-13:00">12:00 - 13:00</option>
                                <option value="13:00-14:00">13:00 - 14:00</option>
                                <option value="14:00-15:00">14:00 - 15:00</option>
                                <option value="15:00-16:00">15:00 - 16:00</option>
                                <option value="16:00-17:00">16:00 - 17:00</option>
                                <option value="17:00-18:00">17:00 - 18:00</option>
                                <option value="18:00-19:00">18:00 - 19:00</option>
                            </select><br>
                        </div>

                        <div id="timeslot_2">
                            <label for="timeslot_2">Créneau horaire (2 heures) :</label>
                            <select name="timeslot_2" required>
                                <option value="08:00-10:00">08:00 - 10:00</option>
                                <option value="09:00-11:00">09:00 - 11:00</option>
                                <option value="10:00-12:00">10:00 - 12:00</option>
                                <option value="11:00-13:00">11:00 - 13:00</option>
                                <option value="12:00-14:00">12:00 - 14:00</option>
                                <option value="13:00-15:00">13:00 - 15:00</option>
                                <option value="14:00-16:00">14:00 - 16:00</option>
                                <option value="15:00-17:00">15:00 - 17:00</option>
                                <option value="16:00-18:00">16:00 - 18:00</option>
                                <option value="17:00-19:00">17:00 - 19:00</option>
                            </select><br>
                        </div> 
                    </div> 

                    <div class="element-form">
                        <label for="description" >Description :</label>
                        <br>
                        <textarea id="desc-form" name="description" rows="5" cols="40" pattern="^(?!.*[<>\&;]).{0,255}$" placeholder="Description de votre projet (255 max)" maxlength="255" ></textarea><br>
                    </div>
                    
                    <div class="element-form">
                        <label for="nombreetu">Nombre d'étudiant(s) :</label>
                        <input type="number" name="nombreetu" min="1" max="4" value="1" pattern="^[1-4]$" required><br>
                    </div>

                    <div class="element-form">
                        <input id="submit-form" type="submit" name="submit" value="Réserver">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- add footer -->
    <?php 
        include '../components/footer.php';
    ?>
</body>
</html>