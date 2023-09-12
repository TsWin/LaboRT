<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Afficher Annonce</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='../../../assets/css/leboncoin.css'>
</head>
<body>
    <?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
    include_once DIR_BASE.'layout/LeboncoinNav.php';
    require_once DIR_BASE.'controllers/AnnoncesController.php';
    
    if (isset($_POST['confirm']) && isset($_GET['id'])) {     
        $id = $_GET['id'];
        if (!checkOwnerAnnonce($id)) {
            echo '<div class="container">';
            echo '<div class="delete-container">';
            echo '<p>Vous ne pouvez pas afficher cette annonce car elle ne vous appartient pas</p>';
            echo '<a class="delete-button" href="'.homeLeboncoin.'annonces/annonce.php?id=' . $id . '">Retour</a>';
            echo '</div>';
            echo '</div>';
            exit;
        } else if ($_POST['confirm'] === 'Non') {
            header('Location: '.homeLeboncoin.'annonces/annonce.php?id=' . $id);
            exit;
        } else if ($_POST['confirm'] === 'Oui') {
            $id = $_GET['id'];
            afficherAnnonce($id);
            header('Location: '.homeLeboncoin.'annonces/');
            exit;
        } else {
            header('Location: '.homeLeboncoin.'annonces/annonce.php?id=' . $id);
            exit;
        }
    } else if (isset($_GET['id'])) {
        $id = $_GET['id'];
        echo '<div class="container">';
        echo '<div class="delete-container">';
        echo '<p>Etes vous sur de vouloir afficher cette annonce ?</p>';
        echo '<form method="post">';
        echo '<button class="delete-button" name="confirm" value="Oui" type="submit">Oui</button>';
        echo '<a class="delete-button" href="'.homeLeboncoin.'annonces/annonce.php?id=' . $id . '">Non</a>';
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

