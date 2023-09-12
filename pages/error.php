<!-- Error page -->
<!-- Change the error type depending of the error get param -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="../assets/css/style.css" rel="stylesheet">
    <title>LaboRT</title>
    <favicon>
        <link rel="icon" type="image/png" href="../assets/img/Labo.png" />
    </favicon>
</head>
<body>
    <?php 
        include '../components/header.php';
    ?>
    <div class="container">
        <div class="landing">
            <div class="text-box">
                <?php
                        switch ($_GET['error']) {
                            case '4000':
                                echo '<h1>Erreur lors de la création de l\'utilisateur</h1>';
                                echo '<p>Une erreur lors de la création de l\'utilisateur est survenue.</p>';
                                break;
                            case '4001':
                                echo '<h1>Erreur d\'authentification</h1>';
                                echo '<p>Une erreur d\'authentification est survenue.</p>';
                                break;
                            case '4002':
                                echo '<h1>Erreur de connexion</h1>';
                                echo '<p>Une erreur de connexion est survenue.</p>';
                                break;
                            case '4003':
                                echo '<h1>Erreur de connexion à la base de données</h1>';
                                echo '<p>Une erreur de connexion à la base de données est survenue.</p>';
                                break;
                            case '4004':
                                echo '<h1>Erreur de token</h1>';
                                echo '<p>Une erreur de token est survenue.</p>';
                                break;
                            case '4005':
                                echo '<h1>Erreur de récupération des données</h1>';
                                echo '<p>Une erreur de récupération des données est survenue.</p>';
                                break;
                            case '4006':
                                echo '<h1>Erreur de modification des données</h1>';
                                echo '<p>Une erreur de modification des données est survenue.</p>';
                                break;
                            case '4007':
                                echo '<h1>Erreur de suppression des données</h1>';
                                echo '<p>Une erreur de suppression des données est survenue.</p>';
                                break;
                            case '4008':
                                echo '<h1>Erreur de création des données</h1>';
                                echo '<p>Une erreur de création des données est survenue.</p>';
                                break;
                            case '4009':
                                echo '<h1>Erreur de vérification des données</h1>';
                                echo '<p>Une erreur de vérification des données est survenue.</p>';
                                break;
                            case '4010':
                                echo '<h1>Erreur interne d\'authentification</h1>';
                                echo '<p>Une erreur interne lors de la gestion des données d\'authentification est survenue.</p>';
                                break;
                            case '4011':
                                echo '<h1>Erreur d\'autorisation</h1>';
                                echo '<p>Vous n\'avez pas les permissions nécessaires pour accéder cette page.</p>';
                                break;
                            case '4012':
                                echo '<h1>Erreur de profile</h1>';
                                echo '<p>Veulliez compléter votre profile.</p>';
                                break;
                            case '4013':
                                echo '<h1>Erreur de modification du profile</h1>';
                                echo '<p>Une erreur de modification du profile est survenue.</p>';
                                break;
                            case '4014':
                                echo '<h1>Erreur de suppression du profile</h1>';
                                echo '<p>Une erreur de suppression du profile est survenue.</p>';
                                break;
                            case '4015':
                                echo '<h1>Erreur de création du profile</h1>';
                                echo '<p>Une erreur de création du profile est survenue.</p>';
                                break;
                            case '4016':
                                echo '<h1>Erreur de réservation</h1>';
                                echo '<p>Plus de stock disponible pour cette annonce.</p>';
                                break;
                            case '4017':
                                echo '<h1>Erreur de réservation</h1>';
                                echo '<p>Vous ne pouvez pas réserver votre propre annonce.</p>';
                                break;
                            case '4018':
                                echo '<h1>Erreur de réservation</h1>';
                                echo '<p>Vous devez être connecté pour pouvoir réserver.</p>';
                                break;
                            default:
                                echo '<h1>Erreur inconnue</h1>';
                                echo '<p>Une erreur inconnue est survenue.</p>';
                                break;
                            }
                ?>
            </div>
        </div>
    </div>
    <?php 
        include '../components/footer.php';
    ?>
</body>
