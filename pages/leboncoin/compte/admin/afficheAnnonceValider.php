<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Annonces</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='../../../../assets/css/leboncoin.css'>
    <!-- <script defer src='../../../assets/js/annonce.js'></script> -->
    <!-- add fontawesom icons -->
    <script src="https://kit.fontawesome.com/df14dc0e3c.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php
        require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
        include_once DIR_BASE.'layout/LeboncoinNav.php';
        require_once DIR_BASE.'controllers/AnnoncesController.php';

        if(isset($_GET['ticket'])){
            login('leboncoin/annonces/create', $_GET['ticket'], true);
        } else {
            login('leboncoin/annonces/create', null, true);
        }
        
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $annonce = getAnnonce($id);
            if ($annonce == null) {
                header('Location: index.php');
            }
        } else {
            header('Location: index.php');
        }

        if ($annonce["image"] == null) {
            $annonce["image"] = 'Labo.png';
        }
        $vendeur = getVendeur($annonce["idrefetu"]);
        $profilepic = getProfilePic($annonce["idrefetu"]);
        $condition = getCondition($annonce["idrefcondition"]);
        $type = getAnnonceType($annonce["idreftype"]);
        $etat = getEtat($annonce["idrefetatannonce"]);
        $statut = getStatut($annonce["idrefetatannonce"], $annonce["stock"], true);
        $nbAnnonce = getNbAnnoncesParVendeur($annonce["idrefetu"]);
        // show the annonce
        echo '<div class="annonce-container">';
        echo '<div class="annonce">';
        echo '<div class="annonce-body">';
        echo '<div class="annonce-body-left">';
        echo '<img src="../../../../upload/'.$annonce["image"].'" alt="image">';
        echo '<h1>'.$annonce["nom"].'</h1>';
        echo '<p>'.$annonce["prix"].' €</p>';
        echo '</div>';
        echo '<div class="annonce-body-right">';
        echo '<div class="annonce-vendeur" name="'.$annonce["idrefetu"].'">';
        echo '<div class="annonce-vendeur-id">';
        if ($profilepic != null) {
            echo '<img src="../../../../upload/users/'.$profilepic.'" alt="image">';
        } else {
            echo '<img src="../../../../assets/img/user.png" alt="image">';
        }
        echo '<div class="annonce-vendeur-id-info">';
        echo '<h2>'.$vendeur.'</h2>';
        echo '<p>'.$nbAnnonce.' annonces</p>';
        echo '</div>';
        echo '</div>';
        echo '<hr>';
        echo '<button class="annonce-vendeur-btn" onclick="window.location.href=\'../../annonces/valider.php?id='.$annonce["idannonce"].'\'">Valider</button>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '<hr>';
        echo '<h2>Details:</h2>';    
        echo '<div class="annonce-footer">';
        echo '<div class="annonce-footer-left">';
        echo '<p>Type: '.$type.'</p>';
        echo '<p>Date d\'Ajout: '.$annonce["datecreation"].'</p>';
        echo '</div>';
        echo '<div class="annonce-footer-right">';
        echo '<p>Condition: '.$condition.'</p>';
        echo '<p>Statut: '.$etat.'</p>';
        echo '</div>';
        echo '</div>';
        echo '<hr>';
        echo '<h2>Description:</h2>';
        echo '<p>'.$annonce["description"].'</p>';
        echo '</div>';
        echo '</div>';
    ?>
</body>
</html>