
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../assets/css/style.css" rel="stylesheet">
    <title>LaboRT - Admin</title>
    <favicon>
        <link rel="icon" type="image/png" href="../../assets/img/Labo.png" />
    </favicon>
</head>
<body class="background-gradient">
    <?php 
        require_once '../../config.php';
        include_once DIR_BASE.'components/headerAdmin.php';
        include_once DIR_BASE.'controllers/AuthController.php';
        include_once DIR_BASE.'controllers/HorairesController.php';
        include_once DIR_BASE.'controllers/EventsController.php';
        if(isset($_GET['ticket'])){
           login('admin/index', $_GET['ticket'], true);
        } else {
           login('admin/index', null, true);
        }

        if (isset($_POST["date"]) && isset($_POST["nom"]) && isset($_POST["description"])) {
            $date = pg_escape_string($_POST["date"]);
            $nom = pg_escape_string($_POST["nom"]);
            $description = pg_escape_string($_POST["description"]);
            $error = null;
            $regexDate = '/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/';
            $regexNom = '/^([a-zA-Z0-9àâäéèêëïîôöùûüçÀÂÄÉÈËÏÎÔÖÙÛÜÇ\s]{1,40})$/';
            $regexDescription = '/^([a-zA-Z0-9àâäéèêëïîôöùûüçÀÂÄÉÈËÏÎÔÖÙÛÜÇ\s]{1,255})$/';
            if (preg_match_all($regexDate, $date) == 0) {
                $error = "La date n'est pas valide";
            } else if (preg_match_all($regexNom, $nom) == 0) {
                $error = "Le nom n'est pas valide";
            } else if (preg_match_all($regexDescription, $description) == 0) {
                $error = "La description n'est pas valide";
            } else {
                createEvent($date, $nom, $description);
                header('Location: ../Events.php');
            }
        }
    ?> 
<div class="landing" id="blocked" style="heigth: 100vh;">  

    <!-- add container where the landing page will be -->
    <div class="text-box" id="space-top">
    
    <div id="form">
    <h2>Création d'un event</h2>
    <?php
    if (isset($error)) {
        echo '<p class="error">' . $error . '</p>';
    }
    ?>
    <form method="POST" action="eventcreate.php">
        <?php
        $day = getDateOfCurrentDay();
        echo '<div class="element-form">';
        echo '<label for="date">Date : </label>';
        echo '<input type="date" name="date" min="' . $day . '" value="' . $day . '" pattern="^\d{4}-\d{2}-\d{2}$" required><br>';
        echo '</div>';
        ?>

        <div class="element-form">
            <label for="nom">Nom :</label>
            <input type="text" name="nom" required><br>
        </div>

        <div class="element-form">
            <label for="description">Description :</label>
            <br>
            <textarea id="desc-form" name="description" rows="5" cols="40" pattern="^(?!.*[<>\&;]).{0,255}$"
                placeholder="Description de l'event (255 max)" maxlength="255"></textarea><br>
        </div>

        <div class="element-form">
            <input id="submit-form" type="submit" name="submit" value="Créer">
        </div>
    </form>
</div>
    <!-- add footer -->
    </div>
</div>
    <?php 
        include DIR_BASE.'components/footer.php';
    ?>
</body>
</html>