<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Mon Compte</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='../../../assets/css/leboncoin.css'>
    <script src="https://kit.fontawesome.com/df14dc0e3c.js" crossorigin="anonymous"></script>
</head>
<body>
<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
    include_once DIR_BASE.'layout/LeboncoinNav.php';
    require_once DIR_BASE.'controllers/AuthController.php';
    require_once DIR_BASE.'controllers/UserController.php';
    if(isset($_GET['ticket'])){
       login('leboncoin/compte/index', $_GET['ticket'], false);
    } else {
       login('leboncoin/compte/index', null, false);
    }
    $user = getUserWithToken($_COOKIE['token']);
        
    $error = null;
    if (isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["email"]) && isset($_POST["groupe"])) {
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $email = $_POST["email"];
        $groupe = $_POST["groupe"];
        $profilepic = "";
        if ($_FILES["image"]["name"]) {
            $target_dir = "../../../upload/users/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $profilepic = basename($_FILES["image"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            // check if image file is a actual image or fake image
            $check = getimagesize($_FILES["image"]["tmp_name"]);
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
            if ($_FILES["image"]["size"] > 500000) {
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
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $error = "Le fichier ". basename( $_FILES["image"]["name"]). " a été téléchargé.";
                } else {
                    $error = "Une erreur est survenue lors du téléchargement du fichier.";
                }
            }
        }
        
        if (empty($nom) || empty($prenom) || empty($email) || empty($groupe)) {
            $error = "Veuillez remplir tous les champs";
        } else {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $user['nom'] = $nom;
                $user['prenom'] = $prenom;
                $user['email'] = $email;
                $user['idrefgroupe'] = $groupe;
                $user['profilepic'] = $profilepic;
                $result = updateUser($user);
                if (is_string($result)) {
                    if (substr($result, 0, 6) === 'ERROR:') {
                        $error = $result;
                    } else {
                        header('Location: index.php');
                    }
                } else {
                    header('Location: index.php');
                }
            } else {
                $error = "Veuillez entrer un email valide";
            }
        }
    }


    

?>

<div class="container">
    <div class="formContainer">
        <h1>Mon Compte</h1>
        <div class="button-group">
            <a href="/pages/leboncoin/annonces/create.php" class="button">Déposer une annonce</a>
            <a href="/pages/leboncoin/compte/reservationsannonces.php" class="button">Réservations de mes annonces</a>
            <a href="/pages/leboncoin/compte/delete.php" class="button">Supprimer mon compte</a>
        </div>
        <form class="profileContainer" method="POST" action="index.php" enctype="multipart/form-data">
            <h1>Mon Profil</h1>
            <?php 
                if ($error != null) {
                    echo '<div class="alert alert-danger" role="alert">';
                    echo $error;
                    echo '</div>';
                }
            ?>
            <div class="profileImage">
                <?php 
                    if ($user['profilepic'] == null) {
                        echo '<img src="../../../assets/img/user.png" alt="profile image">';
                    } else {
                        echo '<img src="../../../upload/users/'.$user['profilepic'].'" alt="profile image">';
                    }
                ?>
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" name="image" id="image">
                </div>
            </div>
            <div class="profileInfo">
                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input class="form-group" type="text" name="nom" id="nom" value="<?php echo $user['nom']; ?>">
                </div>
                <div class="form-group">
                    <label for="prenom">Prénom</label>
                    <input class="form-group" type="text" name="prenom" id="prenom" value="<?php echo $user['prenom']; ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input class="form-group" type="email" name="email" id="email" value="<?php echo $user['email']; ?>">
                </div>
                <div class="form-group">
                    <label for="groupe">Groupe</label>
                    <select name="groupe" id="groupe">
                    <?php
                        $groupes = getGroupes();
                        foreach ($groupes as $groupe) {
                            if ($groupe['idgroupe'] == 1) {
                                continue;
                            }
                            if ($groupe['idgroupe'] == $user['idrefgroupe']) {
                                echo '<option value="'.$groupe['idgroupe'].'" selected>'.$groupe['nomgroupe'].'</option>';
                                continue;
                            }
                            echo '<option value="'.$groupe['idgroupe'].'">'.$groupe['nomgroupe'].'</option>';
                        }
                    ?>
                    </select>
                </div>
                <div class="form-group">
                    <input id="submit-button" type="submit" value="Modifier">
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>