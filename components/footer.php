<footer class="footer">
    <div class="footer-menu">
        <ul>
            <li><a class="bug" href="/pages/Horaires.php" title="Horaires">Horaires</a></li>
            <li><a class="bug" href="/pages/Contact.php" title="Contact">Contact</a></li>
            <?php
                include_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
                include_once DIR_BASE.'controllers/UserController.php';
                include_once DIR_BASE.'controllers/AuthController.php';
                if(checklogin()){
                    $user= getUserWithToken($_COOKIE['token']);
                    $test= getStaff($user['idetu']);
                    if($test==true){
                        echo '<li><a class="bug" href="/pages/admin/" title="Events">Admin</a></li>';
                    }
                }
                else{
                    echo '<li><a class="bug" href="/pages/Events.php" title="Events">Events</a></li>';
                }
            ?>
        </ul>
    </div>
    <div class="footer-social">
        <ul>
            <li><a href="https://www.youtube.com/watch?v=xvFZjo5PgG0" target="_blank"><img src="/assets/img/socials/icons8-instagram-50.png"
                        alt="Instagram"></a></li>
            <li><a href="https://discord.com/invite/CFYwFCaDJn" target="_blank"><img
                        src="/assets/img/socials/icons8-discord-50.png" alt="Discord"></a></li>
            <li><a href="https://ctftime.org/team/200491" target="_blank"><img
                        src="/assets/img/socials/icons8-time-50.png" alt="CTF-Time"></a></li>
        </ul>
    </div>
    <div class="footer-credits">
        <p>© 2023 LaboRT. All rights reserved.</p>
    </div>
</footer>