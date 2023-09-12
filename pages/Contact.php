<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/style.css" rel="stylesheet">
    <script defer src="../assets/js/contact.js"></script>
    <title>LaboRT</title>
    <favicon>
        <link rel="icon" type="image/png" href="../assets/img/Labo.png"/>
    </favicon>
</head>
<body class="background-gradient">
    <?php
        require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
        require_once DIR_BASE.'./controllers/ContactController.php';
        include_once '../components/header.php';
    ?>
    <div class="landing" id="blocked">
        <div class="text-box" id="space-top">
            <h1>Staff du Labo RT</h1>
            <p>Voici les membres du staff du Labo RT :</p>

            <div class="member">
                <?php
                    $email=getemail('Président');
                    if (empty($email)){
                        $email[0]='none';
                    }
                    $name=getname('Président');
                    if (empty($name)){
                        $name[0]='Donnée';
                        $name[1]='Manquante';
                    }
                    $photo=getStaffProfilePic('Président');
                    if (empty($photo)){
                        $photo='default.png';
                    }
                    echo "<a href='mailto: ".$email[0]."'><img class='image' src='../assets/img/photo_staff/".$photo."' alt='Photo du Président'></a> "; 
                    echo "<h2> ". $name[0]." ".$name[1] ."</h2>";
                ?>
                <p>Président</p>
                <p>Responsable de la gestion de l'association.</p>
            </div>

            <div class="member">
                <?php
                    $email=getemail('Vice-Président');
                    if (empty($email)){
                        $email[0]='none';
                    }
                    $name=getname('Vice-Président');
                    if (empty($name)){
                        $name[0]='Donnée';
                        $name[1]='Manquante';
                    }
                    $photo=getStaffProfilePic('Vice-Président');
                    if (empty($photo)){
                        $photo='default.png';
                    }
                    echo "<a href='mailto: ".$email[0]."'><img class='image' src='../assets/img/photo_staff/".$photo."' alt='Photo du Vice-Président'></a>"; 
                    echo "<h2> ". $name[0]." ".$name[1] ."</h2>";
                ?>
                <p>Vice-Président</p>
                <p>Assiste le président dans la gestion de l'association.</p>
            </div>

            <div class="member">
                <?php
                    $email=getemail('Trésorier');
                    if (empty($email)){
                        $email[0]='none';
                    }
                    $name=getname('Trésorier');
                    if (empty($name)){
                        $name[0]='Donnée';
                        $name[1]='Manquante';
                    }
                    $photo=getStaffProfilePic('Trésorier');
                    if (empty($photo)){
                        $photo='default.png';
                    }
                    echo "<a href='mailto: ".$email[0]."'><img class='image' src='../assets/img/photo_staff/".$photo."' alt='Photo du Trésorier'></a> ";
                    echo "<h2> ". $name[0]." ".$name[1] ."</h2>";
                ?>
                <p>Trésorier</p>
                <p>Gère les finances de l'association.</p>
            </div>

            <div class="member">
                <?php
                    $email=getemail('Secrétaire');
                    if (empty($email)){
                        $email[0]='none';
                    }
                    $name=getname('Secrétaire');
                    if (empty($name)){
                        $name[0]='Donnée';
                        $name[1]='Manquante';
                    }
                    $photo=getStaffProfilePic('Secrétaire');
                    if (empty($photo)){
                        $photo='default.png';
                    }
                    echo "<a href='mailto: ".$email[0]."'><img class='image' src='../assets/img/photo_staff/".$photo."' alt='Photo du Secrétaire'></a> "; 
                    echo "<h2> ". $name[0]." ".$name[1] ."</h2>";
                ?>
                <p>Secrétaire</p>
                <p>Gère la correspondance et les comptes-rendus de l'association.</p>
            </div>

            <div class="member">
                <?php
                    $email=getemail('Community Manager');
                    if (empty($email)){
                        $email[0]='none';
                    }
                    $name=getname('Community Manager');
                    if (empty($name)){
                        $name[0]='Donnée';
                        $name[1]='Manquante';
                    }
                    $photo=getStaffProfilePic('Community Manager');
                    if (empty($photo)){
                        $photo='default.png';
                    }
                    echo "<a href='mailto: ".$email[0]."'><img class='image' src='../assets/img/photo_staff/".$photo."' alt='Photo du community Manager'></a> "; 
                    echo "<h2> ". $name[0]." ".$name[1] ."</h2>";
                ?>
                <p>Community Manager</p>
                <p>Gère les réseaux sociaux de l'association.</p>
            </div>

            <div class="member">
                <?php
                    $email=getemail('Responsable CTF');
                    if (empty($email)){
                        $email[0]='none';
                    }
                    $name=getname('Responsable CTF');
                    if (empty($name)){
                        $name[0]='Donnée';
                        $name[1]='Manquante';
                    }
                    $photo=getStaffProfilePic('Responsable CTF');
                    if (empty($photo)){
                        $photo='default.png';
                    }
                    echo "<a href='mailto: ".$email[0]."'><img class='image' src='../assets/img/photo_staff/".$photo."' alt='Photo du Responsable CTF'></a> "; 
                    echo "<h2> ". $name[0]." ".$name[1] ."</h2>";
                ?>
                <p>Responsable CTF</p>
                <p>Organise les CTFs du Labo RT.</p>
            </div>
        </div>
    </div>
    <!-- add footer -->
    <?php 
        include '../components/footer.php';
    ?>
</body>
</html>