<?php
    set_include_path($_SERVER['DOCUMENT_ROOT'].'/');
    require_once 'config.php';
    require_once 'controllers/SessionController.php';
    require_once 'controllers/DBController.php';
    require_once 'controllers/UserController.php';
    function login($path, $ticket, $admin) {

        $loggedIn = checkLogin();
        
        if (!isset($path)) {
            $path = '';
        } else {
            if (file_exists(DIR_BASE.'pages/'.$path.'.php')) {
                $path = 'pages/'.$path.'.php';
            } else {
                $path = '';
            }
        }
        if (!$loggedIn && !isset($ticket)) {
                header('Location: '.casURL.$path);
        } elseif (!$loggedIn && isset($ticket)) {
            $response = file_get_contents(casValidateURL.$path.'&ticket='.$ticket);
            if (!$response) {
                header('Location: '.errorURL.'4009');
            } elseif (preg_match('/cas:authenticationSuccess/', $response)) {
                preg_match('/<cas:user>(.*)<\/cas:user>/', $response, $matches);
                $etuLogin = $matches[1];
                if (!checkUserExists($etuLogin)) {
                    $token = createUser($etuLogin);
                    if (!$token) {
                       return header('Location: '.errorURL.'4003');
                    }
                    setcookie('token', $token, time() + 3600, '/');
                } else {
                    $token = getToken($etuLogin);
                    setcookie('token', $token, time() + 3600, '/');
                }
                if ($admin) {
                    $user = getUser($etuLogin);
                    $isStaff = getStaff($user['idetu']);
                    if (!$isStaff) {
                        header('Location: '.errorURL.'4011');
                    }
                } else {
                    header('Location: '.homeURL.$path);
                }
            } else {
                header('Location: '.errorURL.'4001');
            }
        } elseif ($loggedIn && $admin) {
            $user = getUserWithToken($_COOKIE['token']);
            $isStaff = getStaff($user['idetu']);
            if (!$isStaff) {
                header('Location: '.errorURL.'4011');
            }
        } 
    }

    function logout() {
        if (isset($_COOKIE['token'])) {
            setcookie('token', '', time() - 3600, '/');
            header('Location: '.casLogoutURL);
        }
    }

    function checkLogin() {
        if (isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];
            try {
                $etuLogin = decryptToken($token);
                if (checkUserExists($etuLogin)) {
                    // TODO: maybe add an extra layer of security later
                    // ? maybe add the id of the user in the token or the cookie creation date
                    $tokenDB = getUserToken($etuLogin); // ! Useless because we already have decrypted the token, to be changed
                    if ($token == $tokenDB) {
                        return true;
                    } else {
                        header('Location: '.errorURL.'4004');
                    }
                } else {
                    return false;
                }
            } catch (Exception $e) {
                header('Location: '.errorURL.'4004');
            }
        } else {
            return false;
        }
    }
?>