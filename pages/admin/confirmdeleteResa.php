<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Supprimer Annonce</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='../../assets/css/style.css'>
</head>

<body class="background-gradient">
    <?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
    require_once DIR_BASE . './controllers/ReservationActiviteController.php';
    require_once DIR_BASE . './controllers/AuthController.php';
    require_once DIR_BASE . './controllers/UserController.php';
    include '../../components/header.php';
    ?>
    <div class="landing" id="event-main">
        <div class="text-box" id="space-top">
            <?php

            if (isset($_GET['ticket'])) {
                login('admin/confirmdeleteResa', $_GET['ticket'], true);
            } else {
                login('admin/confirmdeleteResa', null, true);
            }
            $user = getUserWithToken($_COOKIE['token']);

            if (isset($_POST['confirm']) && isset($_GET['id'])) {
                $id = $_GET['id'];
                if ($_POST['confirm'] === 'Oui') {
                    deleteReservation($id);
                    header('Location: reservations.php');
                    exit;
                } else {
                    header('Location: reservations.php');
                    exit;
                }
            } else {
                echo '<div class="delete-container">';
                echo '<p>Etes vous sur de vouloir supprimer cette réservation ?</p>';
                echo '<form method="post">';
                echo '<button class="button" name="confirm" value="Oui" type="submit">Oui</button>';
                echo '<a class="button" href="./reservations.php">Non</a>';
                echo '</form>';
                echo '</div>';
            }
            ?>
</body>

</html>