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
    require_once DIR_BASE.'controllers/AuthController.php';
    require_once DIR_BASE.'controllers/UserController.php';

    if(isset($_GET['ticket'])){
        login('leboncoin/compte/delete', $_GET['ticket'], false);
     } else {
        login('leboncoin/compte/delete', null, false);
     }
     $user = getUserWithToken($_COOKIE['token']);
    
    if (isset($_POST['confirm'])) {     
        $id = $_GET['id'];
        if ($_POST['confirm'] === 'Non') {
            header('Location: '.homeLeboncoin.'compte/index.php');
            exit;
        } else if ($_POST['confirm'] === 'Oui') {
            deleteUser($user['id']);
            header('Location: '.homeLeboncoin.'annonces/');
            exit;
        } else {
            header('Location: '.homeLeboncoin.'annonces/');
            exit;
        }
    } else {
        echo '<div class="container">';
        echo '<div class="delete-container">';
        echo '<p>Etes vous sur de vouloir vous supprimer ?</p>';
        echo '<form method="post">';
        echo '<button class="delete-button" name="confirm" value="Oui" type="submit">Oui</button>';
        echo '<a class="delete-button" href="'.homeLeboncoin.'compte/index.php">Non</a>';
        echo '</form>';
        echo '</div>';
        echo '</div>';
    }
?>
</body>
</html>
