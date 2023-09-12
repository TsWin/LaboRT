<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Annonces</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='../../../../assets/css/leboncoin.css'>
    <script defer src='../../../assets/js/annonce.js'></script>
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
 ?>
 <div class="admin-options">
    <a href="./approuver.php">Approbation des annonces</a>
    <a href="./gestionAnnonce.php">Gestion des annonces</a>
    <a href="./gestionResa.php">Gestion des réservations</a>
</div>
</body>
</html>