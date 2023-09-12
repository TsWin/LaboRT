<?php 
    require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
    function createToken($etuLogin) {
        // get the key in key.txt
        $key = file_get_contents(KEY_FILE);
        // create a token with the key and the login
        // use the key to encrypt the login
        $token = openssl_encrypt($etuLogin, 'AES-128-ECB', $key);
        // return the token
        return $token;
    }

    function getToken($etuLogin) {
        $connex = connectDB();
        $sql = "SELECT token FROM etudiants WHERE login='$etuLogin'";
        $result = $connex->query($sql);
        $row = $result->fetch();
        $token = $row['token'];
        return $token;
    }
    function decryptToken($token) {
        $key = file_get_contents(KEY_FILE);
        $etuLogin = openssl_decrypt($token, 'AES-128-ECB', $key);
        return $etuLogin;
    }
?>