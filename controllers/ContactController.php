<?php
set_include_path($_SERVER['DOCUMENT_ROOT'].'/controllers/');
require_once 'DBController.php';

function getemail($role){
    $connex = connectDB();
    $query= "SELECT email FROM etudiants Inner Join staff on etudiants.idetu = staff.idrefetu Inner Join role on staff.idrefrole = role.idrole where role.nomrole = :role";
    $result = $connex->prepare($query);
    $result->bindParam(':role', $role);
    $result->execute();
    if (empty($result)){
        return $result;
    }
    else{
        $email = $result->fetch();
        return $email;
    }
}

function getname($role){
    $connex = connectDB();
    $query= "SELECT prenom, nom FROM etudiants Inner Join staff on etudiants.idetu = staff.idrefetu Inner Join role on staff.idrefrole = role.idrole where role.nomrole = :role";
    $result = $connex->prepare($query);
    $result->bindParam(':role', $role);
    $result->execute();
    if (empty($result)){
        return $result;
    }
    else{
        $name = $result->fetch();
        return $name;
    }
}

function getStaffProfilePic($role){
    $connex = connectDB();
    $query= "SELECT profilepic FROM etudiants Inner Join staff on etudiants.idetu = staff.idrefetu Inner Join role on staff.idrefrole = role.idrole where role.nomrole = :role";
    $result = $connex->prepare($query);
    $result->bindParam(':role', $role);
    $result->execute();
    if (empty($result)){
        return $result;
    }
    else {
        $photo = $result->fetch();
        $photo = $photo[0];
        return $photo;
    }
}
?>