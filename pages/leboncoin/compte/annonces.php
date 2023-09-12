<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Annonces</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='../../../assets/css/leboncoin.css'>
    <script defer src='../../../assets/js/annonce.js'></script>
    <!-- add fontawesom icons -->
    <script src="https://kit.fontawesome.com/df14dc0e3c.js" crossorigin="anonymous"></script>
</head>
<body>
<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
    include_once DIR_BASE.'layout/LeboncoinNav.php';
    require_once DIR_BASE.'controllers/AnnoncesController.php'; 
    require_once DIR_BASE.'controllers/AuthController.php';
    require_once DIR_BASE.'controllers/UserController.php';
    if(isset($_GET['ticket'])){
       login('leboncoin/compte/annonces', $_GET['ticket'], false);
    } else {
       login('leboncoin/compte/annonces', null, false);
    }
    $user = getUserWithToken($_COOKIE['token']);

    if (isset($_GET['type']) && isset($_GET['sort'])) {
        $type = $_GET['type'];
        $sort = $_GET['sort'];
        if ($type == 'all' && $sort == 'all') {
            $annonces = getAnnoncesParVendeur($user['idetu']);
            if ($sort != 'all') {
                $annonces = sortAnnoncesBy($annonces, $sort);
            }
        } else if ($type == 'all') {
            $annonces = getAnnoncesParVendeur($user['idetu']);
            $annonces = sortAnnoncesBy($annonces, $sort);
        } else {
            $annonces = getAnnoncesByType($type, false);
            $annonces = filtreAnnoncesParVendeur($annonces, $user['idetu']);
            $annonces = sortAnnoncesBy($annonces, $sort);

        }
    } else if (isset($_GET['type'])) {
        $type = $_GET['type'];
        if ($type == 'all') {
            $annonces = getAnnoncesParVendeur($user['idetu']);
        } else {
            $annonces = getAnnoncesByType($type, false);
            $annonces = filtreAnnoncesParVendeur($annonces, $user['idetu']);
        }
    } else if (isset($_GET['sort'])) {
        $sort = $_GET['sort'];
        $annonces = getAnnoncesParVendeur($user['idetu']);
        if ($sort != 'all') {
            $annonces = sortAnnoncesBy($annonces, $sort);
        }
    } else {
        $annonces = getAnnoncesParVendeur($user['idetu']);
    }



?>

<div class="articleContainer">
    <div id="annonces" class="annonces">
        <h1>Mes Annonces</h1>
        <div class="sort">
            <div class="sort-dropdown">
                <select name="sort" id="sortAnnonce">
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
            </div>
            <div class="sort-dropdown">
                <select name="type" id="typeAnnonce">
                    <optgroup selected label="Catégorie">
                        <option value="all">Aucun Filtre</option>
                        <?php 
                            $types = getTypes();
                            foreach ($types as $type) {
                                if (isset($_GET['type'])) {
                                    if ($type[0] == $_GET['type']) {
                                        echo '<option selected value="'.$type[0].'">'.$type[1].'</option>';
                                    } else {
                                        echo '<option value="'.$type[0].'">'.$type[1].'</option>';
                                    }
                                } else {
                                    echo '<option value="'.$type[0].'">'.$type[1].'</option>';
                                }
                            }
                        ?>
                    </optgroup>
                </select>
            </div>
        </div>
        <?php
            if (!$annonces) {
                echo '<h1>Aucune annonce trouvée</h1>';
            }
            foreach ($annonces as $annonce) {
                if ($annonce["image"] == null) {
                    $annonce["image"] = 'Labo.png';
                }
                $vendeur = getVendeur($annonce["idrefetu"]);
                $condition = getCondition($annonce["idrefcondition"]);
                $etat = getEtat($annonce["idrefetatannonce"]);
                echo '<div class="annonce-item" onclick="window.location.href=\'annonce.php?id='.$annonce["idannonce"].'\'">';
                // echo '<div class="annonce-item" name="'.$annonce->idannonce.'">';
                echo '<div class="annonce-img">';
                echo '<img src="../../../upload/'.$annonce["image"].'" alt="image">';
                echo '</div>';
                echo '<div class="annonce-text">';
                echo '<div class="annonce-text-left">';
                echo '<h2>'.$annonce["nom"].'</h2>';
                echo '<p>Stock disponible: '.$annonce["stock"].'</p>';
                echo '</div>';
                echo '<div class="annonce-text-right">';
                echo '<p>'.$annonce["datecreation"].'</p>';
                echo '<p>Statut: '.$etat.'</p>';
                echo '<p>'.$annonce["prix"].'€</p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        ?>
    </div>
</div>
</body>
</html>