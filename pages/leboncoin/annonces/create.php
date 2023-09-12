<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Create Annonces</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='../../../assets/css/leboncoin.css'>
    <!-- add fontawesom icons -->
    <script src="https://kit.fontawesome.com/df14dc0e3c.js" crossorigin="anonymous"></script>
</head>
<body>
<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
    include_once DIR_BASE.'layout/LeboncoinNav.php';
    require_once DIR_BASE.'controllers/AnnoncesController.php'; 
    require_once DIR_BASE.'controllers/UserController.php';
    
//    create the create page for an annonce
//  need to be logged first and the user needs to have the prenom, nom and email filled in the database
    if(isset($_GET['ticket'])){
        login('leboncoin/annonces/create', $_GET['ticket'], false);
    } else {
        login('leboncoin/annonces/create', null, false);
    }
    $user = getUserWithToken($_COOKIE['token']);
    if ($user) {
        if ($user['prenom'] == null || $user['nom'] == null || $user['email'] == null || $user['idrefgroupe'] == null || $user['idrefgroupe'] == 1) {
            header('Location: '.errorURL.'4012');
        }
    }

    $error = null;
    if ( isset($_POST['nom']) && isset($_POST['description']) && isset($_POST['prix']) && isset($_POST['stock']) && isset($_POST['idreftype']) && isset($_POST['idrefcondition']) && isset($_FILES["image"]) ) {
        $nom = pg_escape_string($_POST['nom']);
        $description = pg_escape_string($_POST['description']);
        $prix = pg_escape_string($_POST['prix']);
        $stock = pg_escape_string($_POST['stock']);
        $idreftype = pg_escape_string($_POST['idreftype']);
        $idrefcondition = pg_escape_string($_POST['idrefcondition']);
        $idrefetu = $user['idetu'];
        $datecreation = date("Y-m-d");

        if (preg_match_all('/[a-zA-Z0-9 ]+/', $nom) == 0) {
            $error = "Le nom de l'annonce ne doit contenir que des lettres et des chiffres.";
        }
        if (preg_match_all('/[a-zA-Z0-9 ]+/', $description) == 0) {
            $error = "La description de l'annonce ne doit contenir que des lettres et des chiffres.";
        }
        if (preg_match_all('/[0-9]+/', $prix) == 0) {
            $error = "Le prix de l'annonce ne doit contenir que des chiffres.";
        }
        if (preg_match_all('/[0-9]+/', $stock) == 0) {
            $error = "Le stock de l'annonce ne doit contenir que des chiffres.";
        }

        // handle image upload
        $target_dir = "../../../upload/";
        $imageFile = $_FILES["image"];
        $target_file = $target_dir . basename(pg_escape_string($imageFile["name"]));
        $image = basename(pg_escape_string($imageFile["name"]));
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // check if image file is a actual image or fake image
        $check = getimagesize(pg_escape_string($imageFile["tmp_name"]));
        if($check !== false) {
            $uploadOk = 1;
        } else {
            $error = "Le fichier n'est pas une image.";
            $uploadOk = 0;
        }
        // check if file already exists
        if (file_exists($target_file)) {
            $error = "Le fichier existe déjà.";
            $uploadOk = 0;
        }
        // check file size
        if ($imageFile["size"] > 500000) {
            $error = "Le fichier est trop volumineux.";
            $uploadOk = 0;
        }
        // allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $error = "Seuls les fichiers JPG, JPEG et PNG sont autorisés.";
            $uploadOk = 0;
        }
        // check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0 && $error == null) {
            $error = "Le fichier n'a pas été téléchargé.";
        // if everything is ok, try to upload file
        } else if ($uploadOk == 1 && $error == null) {
            if (move_uploaded_file(pg_escape_string($imageFile["tmp_name"]), $target_file)) {
                $annonce = array(
                    'nom' => $nom,
                    'description' => $description,
                    'prix' => $prix,
                    'stock' => $stock,
                    'idreftype' => $idreftype,
                    'idrefcondition' => $idrefcondition,
                    'idrefetatannonce' => 2,
                    'idrefetu' => $idrefetu,
                    'datecreation' => $datecreation,
                    'image' => $image
                );
                createAnnonce($annonce);
                echo '<script>alert("Annonce créée avec succès !")</script>';
                header('Refresh: 0.1; URL=../compte/annonces.php');
            } else {
                $error = "Une erreur est survenue lors du téléchargement du fichier.";
            }
        }

    } else if ( isset($_POST['nom']) || isset($_POST['description']) || isset($_POST['prix']) || isset($_POST['stock']) || isset($_POST['idreftype']) || isset($_POST['idrefcondition']) || isset($_FILES["image"]) ) {
        $error = "Veuillez remplir tous les champs";
    }
   
    echo '<div class="container">';
    echo '<div class="formContainer">';
    echo '<h1>Créer une annonce</h1>';
    if ($error != null) {
        echo '<div class="alert alert-danger" role="alert">';
        echo $error;
        echo '</div>';
    }
    echo '<form action="" method="post" enctype="multipart/form-data">';
    echo '<div class="form-group">';
    echo '<label for="nom">Nom</label>';
    echo '<input type="text" name="nom" id="nom" placeholder="Nom de l\'annonce" required pattern="[a-zA-Z0-9 ]+">';
    echo '</div>';
    echo '<div class="form-group">';
    echo '<label for="description">Description</label>';
    echo '<textarea name="description" id="description" cols="30" rows="10" placeholder="Description de l\'annonce" required pattern="[a-zA-Z0-9 ]+"></textarea>';
    echo '</div>';
    echo '<div class="form-group">';
    echo '<label for="prix">Prix</label>';
    echo '<input type="number" name="prix" id="prix" placeholder="Prix de l\'annonce" required pattern="[0-9]+">';
    echo '</div>';
    echo '<div class="form-group">';
    echo '<label for="stock">Stock</label>';
    echo '<input type="number" name="stock" id="stock" placeholder="Stock de l\'annonce" required pattern="[0-9]+">';
    echo '</div>';
    echo '<div class="form-group">';
    echo '<label for="idreftype">Type</label>';
    echo '<select name="idreftype" id="idreftype" required>';
    $types = getTypes();
    foreach ($types as $type) {
        if ($type['idtype'] == 1) {
            continue;
        }
        echo '<option value="'.$type['idtype'].'">'.$type['nomtype'].'</option>';
    }
    echo '</select>';
    echo '</div>';
    echo '<div class="form-group">';
    echo '<label for="idrefcondition">Condition</label>';
    echo '<select name="idrefcondition" id="idrefcondition" required>';
    $conditions = getConditions();
    foreach ($conditions as $condition) {
        if ($condition['idcondition'] == 1) {
            continue;
        }
        echo '<option value="'.$condition['idcondition'].'">'.$condition['nomcondition'].'</option>';
    }
    echo '</select>';
    echo '</div>';
    echo '<div class="form-group">';
    echo '<label for="image">Image</label>';
    echo '<input type="file" name="image" id="image" required>';
    echo '</div>';
    echo '<div class="form-group">';
    echo '<input id="submit-button" type="submit" value="Créer">';
    echo '</div>';
    echo '</form>';
    echo '</div>';
    echo '</div>';

?> 