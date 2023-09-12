<footer class="footer">
            <div class="footer-menu">
                <ul>
                    <li><a class="bug" href="/index.php" title="LaboRT">Labo RT</a></li>
                    <li><a class="bug" href="/pages/leboncoin/annonces/" title="Boutique">Boutique</a></li>
                    <?php
                        if($test==true){
                            echo '<li><a class="bug" href="/pages/leboncoin/compte/admin/" title="Admin">Admin</a></li>';
                        }
                        else {
                            echo '<li><a class="bug" href="/pages/leboncoin/compte/" title="Mon Compte">Mon Compte</a></li>';
                        }
                    ?>
                </ul>
            </div>
            <div class="footer-social">
                <ul>
                    <li><a href="https://" target="_blank"><img src="/assets/img/socials/icons8-instagram-50.png" alt="Instagram"></a></li>
                    <li><a href="https://discord.com/invite/CFYwFCaDJn" target="_blank"><img src="/assets/img/socials/icons8-discord-50.png" alt="Discord"></a></li>
                    <li><a href="https://ctftime.org/team/200491" target="_blank"><img src="/assets/img/socials/icons8-time-50.png" alt="CTF-Time"></a></li>
                </ul>
            </div>
            <div class="footer-credits">
                <p>© 2023 LeboncoinRT. All rights reserved.</p>
            </div>
    </footer>