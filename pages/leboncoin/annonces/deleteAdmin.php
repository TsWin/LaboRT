<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Supprimer Annonce</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='../../../assets/css/leboncoin.css'>
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
    
    if (isset($_POST['confirm']) && isset($_GET['id'])) {     
        $id = $_GET['id'];
        if (checkAnnonceHasReservation($id)) {
            echo '<div class="container">';
            echo '<div class="delete-container">';
            echo '<p>Vous ne pouvez pas supprimer cette annonce car elle a une réservation en cours</p>';
            echo '<a class="delete-button" href="'.homeLeboncoin.'annonces/annonce.php?id=' . $id . '">Retour</a>';
            echo '</div>';
            echo '</div>';
            exit;
        } else if ($_POST['confirm'] === 'Oui') {
            $id = $_GET['id'];
            deleteAnnonce($id);
            header('Location: '.homeLeboncoin.'compte/admin/gestionAnnonce.php');
            exit;
        } else {
            header('Location: '.homeLeboncoin.'compte/admin/afficheAnnonceGestion.php?id=' . $id);
            exit;
        }  
    } else if (isset($_GET['id'])) {
        $id = $_GET['id'];
        echo '<div class="container">';
        echo '<div class="delete-container">';
        echo '<p>Etes vous sur de vouloir supprimer cette annonce ?</p>';
        echo '<form method="post">';
        echo '<button class="delete-button" name="confirm" value="Oui" type="submit">Oui</button>';
        echo '<a class="delete-button" href="'.homeLeboncoin.'compte/admin/afficheAnnonceGestion.php?id=' . $id . '">Non</a>';
        echo '</form>';
        echo '</div>';
        echo '</div>';
    } else {
        header('Location: '.homeLeboncoin.'annonces/annonce.php?id=' . $id);
        exit;
    }
?>
</body>
</html>
