<?php
    set_include_path($_SERVER['DOCUMENT_ROOT'].'/controllers/');
    require_once 'DBController.php';

    class Commandes {
        public $idcommande;
        public $idreservation;
        public $idannonce;
        public $idrefetatreservation;
        public $idrefetatannonce;
        public $idrefetu;
        public $idrefvendeur;
        public $datecreationreservation;
        public $datecreationannonce;
        public $idreftype;
        public $nom;
        public $description;
        public $prix;
        public $image;
        public $stock;
        public $idrefcondition;
    }
    
    function createReservation($reservation) {
        $connex = connectDB();
        $sql = "INSERT INTO reservation (idrefannonce, idrefetatreservation, idrefetu, datecreation) VALUES (:idrefannonce, :idrefetatreservation, :idrefetu, :datecreation);";
        $result = $connex->prepare($sql);
        $result->bindParam(':idrefannonce', $reservation['idrefannonce']);
        $result->bindParam(':idrefetatreservation', $reservation['idrefetatreservation']);
        $result->bindParam(':idrefetu', $reservation['idrefetu']);
        $result->bindParam(':datecreation', $reservation['datecreation']);
        $result->execute();
    }

    function createCommande($reservations) {
        $commandes = array();
        foreach ($reservations as $reservation) {
            $commande = new Commandes();
            $commande->idcommande = $reservation['idreservation'] + $reservation['idrefannonce'];
            $commande->idreservation = $reservation['idreservation'];
            $commande->idannonce = $reservation['idrefannonce'];
            $commande->idrefetatreservation = $reservation['idrefetatreservation'];
            $commande->idrefetatannonce = getAnnonce($reservation['idrefannonce'])['idrefetatannonce'];
            $commande->idrefetu = $reservation['idrefetu'];
            $commande->idrefvendeur = getAnnonce($reservation['idrefannonce'])['idrefetu'];
            $commande->datecreationreservation = $reservation['datecreation'];
            $commande->datecreationannonce = getAnnonce($reservation['idrefannonce'])['datecreation'];
            $commande->idreftype = getAnnonce($reservation['idrefannonce'])['idreftype'];
            $commande->nom = getAnnonce($reservation['idrefannonce'])['nom'];
            $commande->description = getAnnonce($reservation['idrefannonce'])['description'];
            $commande->prix = getAnnonce($reservation['idrefannonce'])['prix'];
            $commande->image = getAnnonce($reservation['idrefannonce'])['image'];
            $commande->stock = getAnnonce($reservation['idrefannonce'])['stock'];
            $commande->idrefcondition = getAnnonce($reservation['idrefannonce'])['idrefcondition'];
            array_push($commandes, $commande);
        }
        return $commandes;
    }

    function getCommande($idreservation) {
        $connex = connectDB();
        $sql = "SELECT * FROM reservation WHERE idreservation = :idreservation;";
        $result = $connex->prepare($sql);
        $result->bindParam(':idreservation', $idreservation);
        $result->execute();
        $reservation = $result->fetch();
        $commande = new Commandes();
        $commande->idcommande = $reservation['idreservation'] + $reservation['idrefannonce'];
        $commande->idreservation = $reservation['idreservation'];
        $commande->idannonce = $reservation['idrefannonce'];
        $commande->idrefetatreservation = $reservation['idrefetatreservation'];
        $commande->idrefetatannonce = getAnnonce($reservation['idrefannonce'])['idrefetatannonce'];
        $commande->idrefetu = $reservation['idrefetu'];
        $commande->idrefvendeur = getAnnonce($reservation['idrefannonce'])['idrefetu'];
        $commande->datecreationreservation = $reservation['datecreation'];
        $commande->datecreationannonce = getAnnonce($reservation['idrefannonce'])['datecreation'];
        $commande->idreftype = getAnnonce($reservation['idrefannonce'])['idreftype'];
        $commande->nom = getAnnonce($reservation['idrefannonce'])['nom'];
        $commande->description = getAnnonce($reservation['idrefannonce'])['description'];
        $commande->prix = getAnnonce($reservation['idrefannonce'])['prix'];
        $commande->image = getAnnonce($reservation['idrefannonce'])['image'];
        $commande->stock = getAnnonce($reservation['idrefannonce'])['stock'];
        $commande->idrefcondition = getAnnonce($reservation['idrefannonce'])['idrefcondition'];
        return $commande;
    }

    function getReservations() {
        $connex = connectDB();
        $sql = "SELECT * FROM reservation;";
        $result = $connex->prepare($sql);
        $result->execute();
        $reservations = $result->fetchAll();
        return $reservations;
    }

    function getReservationsParEtu($idetu) {
        $connex = connectDB();
        $sql = "SELECT * FROM reservation WHERE idrefetu = :idrefetu;";
        $result = $connex->prepare($sql);
        $result->bindParam(':idrefetu', $idetu);
        $result->execute();
        $reservations = $result->fetchAll();
        return $reservations;
    }

    function getReservationsParVendeur($idrefvendeur) {
        $reservations = getReservations();
        $commandes = createCommande($reservations);
        $commandesParVendeur = array();
        foreach ($commandes as $commande) {
            if ($commande->idrefvendeur == $idrefvendeur) {
                array_push($commandesParVendeur, $commande);
            }
        }
        return $commandesParVendeur;
    }

    function getReservation($idreservation) {
        $connex = connectDB();
        $sql = "SELECT * FROM reservation WHERE idreservation = :idreservation;";
        $result = $connex->prepare($sql);
        $result->bindParam(':idreservation', $idreservation);
        $result->execute();
        $reservation = $result->fetch();
        return $reservation;
    }

    function annulerReservation($idreservation, $idrefetatreservation) {
        require_once 'AnnoncesController.php';
        $reservation = getReservation($idreservation);
        $annonce = getAnnonce($reservation['idrefannonce']);
        $idrefetatannonce = $annonce['idrefetatannonce'];
        if ($annonce['stock'] == 0) {
            $idrefetatannonce = 3;
        }
        $stock = $annonce['stock'] + 1;
        $connex = connectDB();
        $sql = "UPDATE reservation SET idrefetatreservation = :idrefetatreservation WHERE idreservation = :idreservation;";
        $result = $connex->prepare($sql);
        $result->bindParam(':idreservation', $idreservation);
        $result->bindParam(':idrefetatreservation', $idrefetatreservation);
        $result->execute();
        $sql = "UPDATE annonces SET stock = :stock, idrefetatannonce = :idrefetatannonce WHERE idannonce = :idannonce;";
        $result = $connex->prepare($sql);
        $result->bindParam(':idannonce', $annonce['idannonce']);
        $result->bindParam(':stock', $stock);
        $result->bindParam(':idrefetatannonce', $idrefetatannonce);
        $result->execute();

    }

    function sortReservationsBy($reservations, $type) {
        switch ($type) {
            case "date":
                usort($reservations, function($a, $b) {
                    $timestampA = explode(" ", $a->datecreationreservation);
                    $timestampB = explode(" ", $b->datecreationreservation);
                    $dateA = explode("-", $timestampA[0]);
                    $dateB = explode("-", $timestampB[0]);
                    $yearA = $dateA[0];
                    $yearB = $dateB[0];
                    $monthA = $dateA[1];
                    $monthB = $dateB[1];
                    $dayA = $dateA[2];
                    $dayB = $dateB[2];
                    $timeA = explode(":", $timestampA[1]);
                    $timeB = explode(":", $timestampB[1]);
                    $hourA = $timeA[0];
                    $hourB = $timeB[0];
                    $minuteA = $timeA[1];
                    $minuteB = $timeB[1];
                    $secondA = $timeA[2];
                    $secondB = $timeB[2];
                    if ($yearA == $yearB) {
                        if ($monthA == $monthB) {
                            if ($dayA == $dayB) {
                                if ($hourA == $hourB) {
                                    if ($minuteA == $minuteB) {
                                        return $secondA - $secondB;
                                    } else {
                                        return $minuteA - $minuteB;
                                    }
                                } else {
                                    return $hourA - $hourB;
                                }
                            } else {
                                return $dayA - $dayB;
                            }
                        } else {
                            return $monthA - $monthB;
                        }
                    } else {
                        return $yearA - $yearB;
                    }
                });
                break;
            case "prix":
                usort($reservations, function($a, $b) {
                    return $a->prix - $b->prix;
                });
                break;
            case "statut":
                usort($reservations, function($a, $b) {
                    return $a->idrefetatreservation - $b->idrefetatreservation;
                });
                break;
            default:
                break;
        }
        return $reservations;
    }

    function getEtatReservation($idrefetat) {
        $connex = connectDB();
        $sql = "SELECT * FROM etatreservation WHERE idetat = :idetat;";
        $result = $connex->prepare($sql);
        $result->bindParam(':idetat', $idrefetat);
        $result->execute();
        $etatreservation = $result->fetch()['nometat'];
        return $etatreservation;
    }
    function getEtatsReservation() {
        $connex = connectDB();
        $sql = "SELECT * FROM etatreservation";
        $result = $connex->prepare($sql);
        $result->execute();
        $etatreservation = $result->fetchAll();
        return $etatreservation;
    }

    function getEtatColor($idrefetatreservation) {
        $couleurs = [
                1 => "#000000",
                2 => "#75ff33",
                3 => "#ff5733",
                4 => "#33abff",
                5 => "#33abff",
                6 => "#ffed33",
                7 => "#ffed33",
                8 => "#ffed33",
                9 => "#008000",
                10 => "#008000"
            ];
        $couleuretatreservation = $couleurs[$idrefetatreservation];

        return $couleuretatreservation;
    }

    function checkOwnerReservation($idreservation) {
        require_once 'UserController.php';
        require_once 'AuthController.php';
        $isLoggedIn = checkLogin();
        if ($isLoggedIn) {
            $user = getUserWithToken($_COOKIE['token']);
            $reservation = getReservation($idreservation);
            if ($user['idetu'] == $reservation['idrefetu']) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function checkOwnerCommande($idreservation) {
        require_once 'UserController.php';
        require_once 'AuthController.php';
        require_once 'AnnoncesController.php';
        $isLoggedIn = checkLogin();
        if ($isLoggedIn) {
            $user = getUserWithToken($_COOKIE['token']);
            $reservation = getReservation($idreservation);
            $commande = getCommande($reservation['idreservation']);
            if ($user['idetu'] == $commande->idrefvendeur) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function updateEtatReservation($id,$etat){
        $connex = connectDB();
        $sql = "UPDATE reservation SET idrefetatreservation = :idrefetatreservation WHERE idreservation = :idreservation;";
        $result = $connex->prepare($sql);
        $result->bindParam(':idreservation', $id);
        $result->bindParam(':idrefetatreservation', $etat);
        $result->execute();
    }
?>