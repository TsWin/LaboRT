<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../assets/css/style.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/df14dc0e3c.js" crossorigin="anonymous"></script>
    <title>LeboncoinRT</title>
    <favicon>
        <link rel="icon" type="image/png" href="../../assets/img/Labo.png" />
    </favicon>
</head>
<body>
    <?php
    require_once '../../config.php';
    include_once DIR_BASE.'/components/headerLeboncoin.php';
    ?>
    <!-- add container where the landing page will be -->
    <div class="container">
        <div class="landing">
            <div class="text-box">
                <h1>Bienvenue sur le site du Leboncoin RT</h1>
                <p>Une plateforme à l'initiative des membres du LaboRT qui permet un réseau de revente de pièces informatique d'occasion parmis les étudiants.</p>
            </div>
            <a href="#apropos"><i id="arrow" class="fa-solid fa-chevron-down fa-bounce fa-xl" style="--fa-animation-duration: 3s; color: #ffffff;"></i></a>
        </div>
    </div>
    <div class="container2" id="apropos">
        <div class="landing">
            <div class="text-box textarea">
                <p>Le "Leboncoin RT" est une initiative innovante lancée par les membres de l'association étudiante Labo RT. Ce réseau de revente de pièces informatiques d'occasion est conçu pour permettre aux étudiants de vendre et d'acheter des composants informatiques d'occasion à des prix abordables.</p>
                <p>En effet, l'achat de pièces informatiques neuves peut souvent être coûteux pour les étudiants, et le "Leboncoin RT" offre une alternative économique et écologique en permettant la revente de pièces en bon état. Cela permet également de réduire le gaspillage et de prolonger la durée de vie des composants informatiques. Le "Leboncoin RT" est facile d'utilisation et est exclusivement réservé aux étudiants. Il offre un réseau sécurisé et fiable pour la revente de pièces informatiques, permettant ainsi aux étudiants de réaliser des économies et de s'entraider dans leur vie étudiante.</p>
            </div>
        </div>
    </div>
    <!-- add footer -->
    <?php
    include DIR_BASE.'/components/footerLeboncoin.php';
    ?>
</body>
</html>