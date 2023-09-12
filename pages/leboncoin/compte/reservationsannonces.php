<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Mes Reservations</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='../../../assets/css/leboncoin.css'>
    <script defer src='../../../assets/js/reservation.js'></script>
    <!-- add fontawesom icons -->
    <script src="https://kit.fontawesome.com/df14dc0e3c.js" crossorigin="anonymous"></script>
</head>
<body>
<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
    include_once DIR_BASE.'layout/LeboncoinNav.php';
    require_once DIR_BASE.'controllers/AnnoncesController.php'; 
    require_once DIR_BASE.'controllers/ReservationController.php'; 
    require_once DIR_BASE.'controllers/AuthController.php';
    require_once DIR_BASE.'controllers/UserController.php';
    if(isset($_GET['ticket'])){
       login('leboncoin/compte/reservationsannonces', $_GET['ticket'], false);
    } else {
       login('leboncoin/compte/reservationsannonces', null, false);
    }
    $user = getUserWithToken($_COOKIE['token']);
    
    
    if (isset($_GET['sort'])) {
        $sort = $_GET['sort'];
        $commandes = getReservationsParVendeur($user['idetu']);
        if ($sort != 'all') {
            $commandes = sortReservationsBy($commandes, $sort);
        }
    } else {
        $commandes = getReservationsParVendeur($user['idetu']);
    }


?>

<div class="articleContainer">
    <div id="annonces" class="annonces">
        <h1>Mes Annonces en Réservations</h1>
        <div class="sort">
            <div class="sort-dropdown">
                <select name="sort" id="sortReservation">
                <optgroup label="Trier par">
                    <?php 
                        if (isset($_GET['sort'])) {
                            $sort = $_GET['sort'];
                            switch ($sort) {
                                case 'all':
                                    echo '<option selected value="all">Aucun Filtre</option>';
                                    echo '<option value="prix">Prix</option>';
                                    echo '<option value="date">Date</option>';
                                    echo '<option value="statut">Statut</option>';
                                    break;
                                case 'prix':
                                    echo '<option value="all">Aucun Filtre</option>';
                                    echo '<option selected value="prix">Prix</option>';
                                    echo '<option value="date">Date</option>';
                                    echo '<option value="statut">Statut</option>';
                                    break;
                                case 'date':
                                    echo '<option value="all">Aucun Filtre</option>';
                                    echo '<option value="prix">Prix</option>';
                                    echo '<option selected value="date">Date</option>';
                                    echo '<option value="statut">Statut</option>';
                                    break;
                                case 'statut':
                                    echo '<option value="all">Aucun Filtre</option>';
                                    echo '<option value="prix">Prix</option>';
                                    echo '<option value="date">Date</option>';
                                    echo '<option selected value="statut">Statut</option>';
                                    break;
                                default:
                                    echo '<option selected value="all">Aucun Filtre</option>';
                                    echo '<option value="prix">Prix</option>';
                                    echo '<option value="date">Date</option>';
                                    echo '<option value="statut">Statut</option>';
                                    break;
                            }
                        } else {
                            echo '<option selected value="all">Aucun Filtre</option>';
                            echo '<option value="prix">Prix</option>';
                            echo '<option value="date">Date</option>';
                            echo '<option value="statut">Statut</option>';
                        }
                    ?>
                </optgroup>
                </select>
                <button onclick="window.location.href='reservations.php'">Voir mes réservations</button>
            </div>
            </div>
        <?php
            if (!$commandes) {
                echo '<h1>Aucune reservation trouvée</h1>';
            } else {
                foreach ($commandes as $commande) {
                    if ($commande->image == null) {
                        $commande->image = 'Labo.png';
                    }
                    $vendeur = getVendeur($commande->idrefetu);
                    $condition = getCondition($commande->idrefcondition);
                    $etat = getEtatReservation($commande->idrefetatreservation);
                    $couleurEtat = getEtatColor($commande->idrefetatreservation);
                    if ($commande->idrefetatreservation == 10 || $commande->idrefetatreservation == 11) {
                        echo '<div class="annonce-item">';
                    }
                    echo '<div class="annonce-item" onclick="window.location.href=\'reservationannonce.php?id='.$commande->idreservation.'\'">';
                    echo '<div class="annonce-img">';
                    echo '<img src="../../../upload/'.$commande->image.'" alt="image">';
                    echo '</div>';
                    echo '<div class="annonce-text">';
                    echo '<div class="annonce-text-left">';
                    echo '<h2>'.$commande->nom.'</h2>';
                    echo '<p> Réservé le :'.$commande->datecreationreservation.'</p>';
                    echo '<p>Réservé par: '.$vendeur.'</p>';
                    echo '<p> Pour '.$commande->prix.'€</p>';
                    echo '</div>';
                    echo '<div class="annonce-text-right">';
                    echo '<p>Statut: <a class="reservation-statut" style="background-color:'.$couleurEtat.'">'.$etat.'</a></p>';
                    echo '<p>Stock Restant: '.$commande->stock.'</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            }
        ?>
    </div>
    </div>
</div>
</body>
</html>