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
        if(isset($_GET['ticket'])){
           login('admin/index', $_GET['ticket'], true);
        } else {
           login('admin/index', null, true);
        }
    ?> 
<div class="landing" style="heigth: 100vh;">  

    <!-- add container where the landing page will be -->
    <div class="text-box" id="space-top">
    
    <a class="button" href="./horairesdelete.php">Suppression des Horaires</a>
    <a class="button" href="./horairescreate.php">Création des Horaires</a>
    <!-- add footer -->
    </div>
</div>
    <?php 
        include DIR_BASE.'components/footer.php';
    ?>
</body>
</html>