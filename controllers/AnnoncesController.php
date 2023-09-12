<?php 
set_include_path($_SERVER['DOCUMENT_ROOT'].'/controllers/');
require_once 'DBController.php';
require_once 'AuthController.php';

function getAnnonces() {
    $connex = connectDB();
    $query = $connex->prepare("SELECT * FROM annonces");
    $query->execute();
    $annonces = $query->fetchAll();
    return $annonces;
}

function getAnnonce($id) { 
    $connex = connectDB();
    $query = $connex->prepare("SELECT * FROM annonces WHERE idannonce = :id");
    $query->bindParam(':id', $id);
    $query->execute();
    $annonce = $query->fetch();
    return $annonce;
}

function getAnnoncesAffiche() {
    $connex = connectDB();
    $query = $connex->prepare("SELECT * FROM annonces WHERE idrefetatannonce NOT IN (1, 2, 5, 6)");
    $query->execute();
    $annonces = $query->fetchAll();
    return $annonces;
}

function getAnnoncesAfficheAdmin() {
    $connex = connectDB();
    $query = $connex->prepare("SELECT * FROM annonces WHERE idrefetatannonce IN (2)");
    $query->execute();
    if (empty($query)) {
        $annonces = "rien";
        return $annonces;
    }
    else {
        $annonces = $query->fetchAll();
        return $annonces;
    }
}

function getAnnoncesParVendeur($idrefetu) {
    $connex = connectDB();
    $query = $connex->prepare("SELECT * FROM annonces WHERE idrefetu = :id");
    $query->bindParam(':id', $idrefetu);
    $query->execute();
    $annoncesParVendeur = $query->fetchAll();
    return $annoncesParVendeur;
}
function getNbAnnoncesParVendeur($idrefetu) {
    $connex = connectDB();
    $query = $connex->prepare("SELECT COUNT(*) FROM annonces WHERE idrefetu = :id");
    $query->bindParam(':id', $idrefetu);
    $query->execute();
    $nbAnnoncesParVendeur = $query->fetch();
    return $nbAnnoncesParVendeur[0];
}
function getVendeur($id) {
    $connex = connectDB();
    $query = $connex->prepare("SELECT * FROM etudiants WHERE idetu = :id");
    $query->bindParam(':id', $id);
    $query->execute();
    $fetchedResult = $query->fetch();
    $vendeur = $fetchedResult['prenom'].' '.$fetchedResult['nom'];
    return $vendeur;
}

function getVendeurPicture($idetu) {
    $connex = connectDB();
    $query = $connex->prepare("SELECT profilepic FROM etudiants WHERE idetu = :id");
    $query->bindParam(':id', $idetu);
    $query->execute();
    $row = $query->fetch();
    return $row['profilepic'];
}

function getCondition($id) {
    $connex = connectDB();
    $query = $connex->prepare("SELECT * FROM `condition` WHERE idcondition = :id");
    $query->bindParam(':id', $id);
    $query->execute();
    $condition = $query->fetch();
    return $condition['nomcondition'];
}

function getEtat($id) {
    $connex = connectDB();
    $query = $connex->prepare("SELECT * FROM etatannonce WHERE idetat = :id");
    $query->bindParam(':id', $id);
    $query->execute();
    $etat = $query->fetch();
    return $etat['nometat'];
}

function getEtats() {
    $connex = connectDB();
    $query = $connex->prepare("SELECT * FROM etatannonce");
    $query->execute();
    $etats = $query->fetchAll();
    return $etats;
}

function getStatut($id, $stock, $modeEtudiant) {
        if ($modeEtudiant) {
            if ($id == 3 && $stock > 0) {
                $statut = "En stock";
            } else if ($id == 4 || $stock == 0) {
                $statut = "Rupture de stock";
            } else {
                $statut = getEtat($id);
            }
        } else {
            $statut = getEtat($id);
        } 
    
    return $statut;
}
function getAnnonceType($typeId) {
    $connex = connectDB();
    $query = $connex->prepare("SELECT * FROM type WHERE idtype = :id");
    $query->bindParam(':id', $typeId);
    $query->execute();
    $type = $query->fetch();
    return $type['nomtype'];
}

function getTypes() {
    $connex = connectDB();
    $query = $connex->prepare("SELECT * FROM type");
    $query->execute();
    $types = $query->fetchAll();
    return $types;
}

function getConditions() {
    $connex = connectDB();
    $query = $connex->prepare("SELECT * FROM condition");
    $query->execute();
    $conditions = $query->fetchAll();
    return $conditions;
}

function getAnnoncesByType($type, $filterAnnonces) {
    $connex = connectDB();
    if ($filterAnnonces) {
        $query = $connex->prepare("SELECT * FROM annonces WHERE idreftype = :type AND idrefetatannonce NOT IN (1, 2, 5, 6)");
    } else {
        $query = $connex->prepare("SELECT * FROM annonces WHERE idreftype = :type");
    }
    $query->bindParam(':type', $type);
    $query->execute();
    $annoncesByType = $query->fetchAll();
    return $annoncesByType;
}

function createAnnonce($annonce) {
    $connex = connectDB();
    $query = $connex->prepare("INSERT INTO annonces (idreftype, nom, description, image, prix, stock, datecreation, idrefcondition, idrefetu, idrefetatannonce) VALUES (:idreftype, :nom, :description, :image, :prix, :stock, :datecreation, :idrefcondition, :idrefetu, :idrefetatannonce)");
    $query->bindParam(':idreftype', $annonce['idreftype']);
    $query->bindParam(':nom', $annonce['nom']);
    $query->bindParam(':description', $annonce['description']);
    $query->bindParam(':image', $annonce['image']);
    $query->bindParam(':prix', $annonce['prix']);
    $query->bindParam(':stock', $annonce['stock']);
    $query->bindParam(':datecreation', $annonce['datecreation']);
    $query->bindParam(':idrefcondition', $annonce['idrefcondition']);
    $query->bindParam(':idrefetu', $annonce['idrefetu']);
    $query->bindParam(':idrefetatannonce', $annonce['idrefetatannonce']);
    $query->execute();
}

function editAnnonce($annonce) {
    $connex = connectDB();
    if ($annonce['image']) {
        $query = $connex->prepare("UPDATE annonces SET idreftype = :idreftype, nom = :nom, description = :description, image = :image, prix = :prix, stock = :stock, datecreation = :datecreation, idrefcondition = :idrefcondition, idrefetu = :idrefetu, idrefetatannonce = :idrefetatannonce WHERE idannonce = :idannonce");
        $query->bindParam(':image', $annonce['image']);
    } else {
        $query = $connex->prepare("UPDATE annonces SET idreftype = :idreftype, nom = :nom, description = :description, prix = :prix, stock = :stock, datecreation = :datecreation, idrefcondition = :idrefcondition, idrefetu = :idrefetu, idrefetatannonce = :idrefetatannonce WHERE idannonce = :idannonce");
    }
    $query->bindParam(':idreftype', $annonce['idreftype']);
    $query->bindParam(':nom', $annonce['nom']);
    $query->bindParam(':description', $annonce['description']);
    $query->bindParam(':prix', $annonce['prix']);
    $query->bindParam(':stock', $annonce['stock']);
    $query->bindParam(':datecreation', $annonce['datecreation']);
    $query->bindParam(':idrefcondition', $annonce['idrefcondition']);
    $query->bindParam(':idrefetu', $annonce['idrefetu']);
    $query->bindParam(':idrefetatannonce', $annonce['idrefetatannonce']);
    $query->bindParam(':idannonce', $annonce['idannonce']);
    $query->execute();
    // $error = $query->errorInfo();
    // if ($error[0] != 0) {
    //     echo $error[2];
    // }
    // return $error;
}

function decreaseStockAnnonce($id) {
    $connex = connectDB();
    $query = $connex->prepare("SELECT stock FROM annonces WHERE idannonce = :id");
    $query->bindParam(':id', $id);
    $query->execute();
    $stock = $query->fetch();
    if ($stock['stock'] == 1) {
        $query2 = $connex->prepare("UPDATE annonces SET idrefetatannonce = 4, stock = 0 WHERE idannonce = :id");
        $query2->bindParam(':id', $id);
        $query2->execute();
    } else {
        $query2 = $connex->prepare("UPDATE annonces SET stock = stock - 1 WHERE idannonce = :id");
        $query2->bindParam(':id', $id);
        $query2->execute();
    }
}

function deleteAnnonce($id) {
    $connex = connectDB();
    $query = $connex->prepare("DELETE FROM annonces WHERE idannonce = :id");
    $query->bindParam(':id', $id);
    $query->execute();
}

function sortAnnoncesBy($annonces, $type) {
    switch ($type) {
        case "prix":
            usort($annonces, function($a, $b) {
                return $a["prix"] - $b["prix"];
            });
            break;
        case "date":
            usort($annonces, function($a, $b) {
                $dateA = explode("-", $a["datecreation"]);
                $dateB = explode("-", $b["datecreation"]);
                $yearA = $dateA[0];
                $yearB = $dateB[0];
                $monthA = $dateA[1];
                $monthB = $dateB[1];
                $dayA = $dateA[2];
                $dayB = $dateB[2];
                if ($yearA == $yearB) {
                    if ($monthA == $monthB) {
                        return $dayA - $dayB;
                    } else {
                        return $monthA - $monthB;
                    }
                } else {
                    return $yearA - $yearB;
                }
            });
            break;
        case "condition":
            usort($annonces, function($a, $b) {
                return $a["idrefcondition"] - $b["idrefcondition"];
            });
            break;
        case "vendeur":
            usort($annonces, function($a, $b) {
                return $a["idrefetu"] - $b["idrefetu"];
            });
            break;
        case "statut":
            usort($annonces, function($a, $b) {
                return $a["idrefetatannonce"] - $b["idrefetatannonce"];
            });
            break;
        default:
            break;
    }
    return $annonces;
}

function searchAnnonces($search) {
    $connex = connectDB();
    $query = $connex->prepare("SELECT * FROM annonces WHERE nom LIKE :search");
    $search = $search."%"; // ? A voir si on veut faire une recherche plus poussée
    // ! ATTENTION : Sécurité à vérifier
    $query->bindParam(':search', $search);
    $query->execute();
    $annoncesBySearch = $query->fetchAll();
    return $annoncesBySearch;
}

function filtreAnnoncesParVendeur($annonces, $id) {
    $annoncesByVendeur = array();
    foreach ($annonces as $a) {
        if ($a['idrefetu'] == $id) {
            array_push($annoncesByVendeur, $a);
        }
    }
    return $annoncesByVendeur;
}

function checkOwnerAnnonce($id) {
    $isLoggedIn = checkLogin();
    if ($isLoggedIn) {
        $user = getUserWithToken($_COOKIE['token']);
        $annonce = getAnnonce($id);
        if ($user['idetu'] == $annonce['idrefetu']) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function checkAnnonceHasReservation($id) {
    $connex = connectDB();
    $query = $connex->prepare("SELECT * FROM reservation WHERE idrefannonce = :id");
    $query->bindParam(':id', $id);
    $query->execute();
    $reservations = $query->fetchAll();
    if (count($reservations) > 0) {
        return true;
    } else {
        return false;
    }
}

function updateEtatAnnonce($id, $etat) {
    $connex = connectDB();
    $query = $connex->prepare("UPDATE annonces SET idrefetatannonce = :etat WHERE idannonce = :id");
    $query->bindParam(':etat', $etat);
    $query->bindParam(':id', $id);
    $query->execute();
}

function desafficherAnnonce($id) {
    updateEtatAnnonce($id, 5);
}

function afficherAnnonce($id) {
    updateEtatAnnonce($id, 2);
}

?>