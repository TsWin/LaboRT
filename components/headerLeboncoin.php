<header>
        <div>
            <a href="/" alt="Labo RT"><img class="logo" src="/assets/img/Labo.png" alt="Logo"></a>
        </div>
        <nav class="menu">
            <ul>
                <li><a class="bug" href="/" title="LaboRT">Labo RT</a></li>
                <li><a class="bug" href="/pages/leboncoin/annonces/" title="Boutique">Boutique</a></li>
                <?php
                    require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
                    set_include_path($_SERVER['DOCUMENT_ROOT'].'/');
                    include_once DIR_BASE.'controllers/UserController.php';
                    include_once DIR_BASE.'controllers/AuthController.php';
                    if(isset($_GET['ticket'])){
                        login('leboncoin/index', $_GET['ticket'], false);
                    } else {
                        login('leboncoin/index', null, false);
                    }
                    $user= getUserWithToken($_COOKIE['token']);
                    $test= getStaff($user['idetu']);
                    if($test==true){
                        echo '<li><a class="bug" href="/pages/leboncoin/compte/admin/" title="Administration">Administration</a></li>';
                    }
                    else {
                        echo '<li><a class="bug" href="/pages/leboncoin/compte/" title="Mon Compte">Mon Compte</a></li>';
                    }
                ?>
            </ul>
    </header>