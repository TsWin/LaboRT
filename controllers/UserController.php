<?php 

function createUser($login, $email = '', $idGroupe = 1) {
    if (!$login) {
        return header('Location: '.errorURL.'4000');
    }
    $token = createToken($login);
    $connex = connectDB();
    $sql = "INSERT INTO etudiants (login, email, idRefGroupe, token) VALUES (:login, :email, :idRefGroupe, :token)";
    $result = $connex->prepare($sql);
    $result->bindParam(':login', $login);
    $result->bindParam(':email', $email);
    $result->bindParam(':idRefGroupe', $idGroupe);
    $result->bindParam(':token', $token);
    $result->execute();
    return $token;
}

function checkUserExists($etuLogin) {
    $connex = connectDB();
    $sql = "SELECT * FROM etudiants WHERE login = :login";
    $result = $connex->prepare($sql);
    $result->bindParam(':login', $etuLogin);
    $result->execute();
    if (!$result) {
        return false;
    } else {
        $row = $result->fetch();
        if (!$row) {
            return false;
        }
        return true;
    }
}

function getUser($etuLogin) {
    $connex = connectDB();
    $sql = "SELECT * FROM etudiants WHERE login = :login";
    $result = $connex->prepare($sql);
    $result->bindParam(':login', $etuLogin);
    $result->execute();
    $row = $result->fetch();
    return $row;
}

function getUserName($idetu) {
    $connex = connectDB();
    $sql = "SELECT prenom, nom FROM etudiants WHERE idetu = :idetu";
    $result = $connex->prepare($sql);
    $result->bindParam(':idetu', $idetu);
    $result->execute();
    $row = $result->fetch();
    $row = $row['prenom'].' '.$row['nom'];
    return $row;
}

function getUserWithToken($token = "") {
    if (!$token) {
        if (checkLogin()) {
            $token = $_COOKIE['token'];
        }
    }
    $connex = connectDB();
    $sql = "SELECT * FROM etudiants WHERE token = :token";
    $result = $connex->prepare($sql);
    $result->bindParam(':token', $token);
    $result->execute();
    $row = $result->fetch();
    return $row;
}

function getUserToken($etuLogin) {
    $connex = connectDB();
    $sql = "SELECT token FROM etudiants WHERE login = :login";
    $result = $connex->prepare($sql);
    $result->bindParam(':login', $etuLogin);
    $result->execute();
    $row = $result->fetch();
    $token = $row['token'];
    return $token;
}

function getUserId($etuLogin) {
    $connex = connectDB();
    $sql = "SELECT idetu FROM etudiants WHERE login = :login";
    $result = $connex->prepare($sql);
    $result->bindParam(':login', $etuLogin);
    $result->execute();
    $row = $result->fetch();
    $id = $row['idetu'];
    return $id;
}

function getStaff($etuId) {
    $connex = connectDB();
    $sql = "SELECT * FROM staff WHERE idRefEtu = :idRefEtu";
    $result = $connex->prepare($sql);
    $result->bindParam(':idRefEtu', $etuId);
    $result->execute();;
    if (!$result) {
        return false;
    } else {
        $row = $result->fetch();
        if (!$row) {
            return false;
        }
        return true;
    }
}

function getGroupe($idGroupe) {
    $connex = connectDB();
    $sql = "SELECT * FROM groupe WHERE idgroupe = :idgroupe";
    $result = $connex->prepare($sql);
    $result->bindParam(':idgroupe', $idGroupe);
    $result->execute();
    $row = $result->fetch();
    return $row;
}

function getGroupes() {
    $connex = connectDB();
    $sql = "SELECT * FROM groupe";
    $result = $connex->prepare($sql);
    $result->execute();
    $row = $result->fetchAll();
    return $row;
}

function getProfilePic($idetu) {
    $connex = connectDB();
    $sql = "SELECT profilepic FROM etudiants WHERE idetu = :idetu";
    $result = $connex->prepare($sql);
    $result->bindParam(':idetu', $idetu);
    $result->execute();
    $row = $result->fetch();
    return $row['profilepic'];
}

function updateUser($user) {
    $connex = connectDB();
    $sql = "UPDATE etudiants SET prenom = :prenom, nom = :nom, email = :email, idrefgroupe = :idrefgroupe, profilepic = :profilepic WHERE login = :login";
    $result = $connex->prepare($sql);
    $result->bindParam(':prenom', $user['prenom']);
    $result->bindParam(':nom', $user['nom']);
    $result->bindParam(':email', $user['email']);
    $result->bindParam(':idrefgroupe', $user['idrefgroupe']);
    $result->bindParam(':profilepic', $user['profilepic']);
    $result->bindParam(':login', $user['login']);
    $result->execute();
    $error = $result->errorInfo();
    if ($error[0] != 0) {
        return $error[2];
    } else {
        return $result;;
    }

    
}

function deleteUser($idetu) {
    $connex = connectDB();
    $sql = "DELETE FROM etudiants WHERE idetu = :idetu";
    $result = $connex->prepare($sql);
    $result->bindParam(':idetu', $idetu);
    $result->execute();
    return $result;
}
?>