<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./assets/css/style.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/df14dc0e3c.js" crossorigin="anonymous"></script>
    <title>LaboRT</title>
    <favicon>
        <link rel="icon" type="image/png" href="./assets/img/Labo.png" />
    </favicon>
</head>
<body>
    <?php 
        require_once './config.php';
        include_once DIR_BASE.'components/header.php';
    ?> 
    <!-- add container where the landing page will be -->
    <div class="container">
        <div class="landing">
            <div class="text-box">
                <h1>Bienvenue sur le site du Labo RT</h1>
                <p>L'association étudiante Labo RT est un groupe d'étudiants passionnés d'informatique et de cybersécurité.</p>
            </div>
            <a href="#apropos"><i id="arrow" class="fa-solid fa-chevron-down fa-bounce fa-xl" style="--fa-animation-duration: 3s; color: #ffffff;"></i></a>
        </div>
    </div>
    <div class="container2" id="apropos">
        <div class="landing">
            <div class="text-box textarea">
                <p>Nous sommes une communauté active et engagée, axée sur l'apprentissage, le partage de connaissances et l'exploration des nouvelles technologies.</p>
                <p>Notre objectif principal est de permettre à nos membres de développer leurs compétences en matière de sécurité informatique, notamment à travers des compétitions de type CTF (Capture The Flag), des conférences et des ateliers pratiques. Nous organisons régulièrement des événements pour sensibiliser notre communauté à l'importance de la cybersécurité, pour promouvoir la collaboration et l'échange de connaissances, ainsi que pour renforcer les liens entre nos membres. Rejoignez notre communauté pour explorer le monde de la cybersécurité et développer vos compétences en sécurité informatique. Nous sommes fiers de rassembler une communauté dynamique, innovante et passionnée, prête à relever tous les défis qui se présentent.</p>
            </div>
        </div>
    </div>
    <!-- add footer -->
    <?php 
        include DIR_BASE.'components/footer.php';
    ?>
</body>
</html>