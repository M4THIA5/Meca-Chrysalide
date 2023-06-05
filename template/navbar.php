<nav>
    <ul>
        <li><a class="navbar-link" href="/MecaChrysalide/index.php">Home</a></li>
        <li><a class="navbar-link" href="/MecaChrysalide/apropos.php">A Propos</a></li>
        <li><a class="navbar-link" href="/MecaChrysalide/boutique.php">Boutique</a></li>
        <li><a class="navbar-link" href="/MecaChrysalide/events.php">Evènements</a></li>
        <?php if (!isConnected()) { ?>
            <li><a class="navbar-link" href="/MecaChrysalide/user/register.php">S'inscrire</a></li>
            <li><a class="navbar-link" href="/MecaChrysalide/user/login.php">Se connecter</a></li>
        <?php } else { ?>
            <li><a class="navbar-link" href="/MecaChrysalide/user/logout.php">Se déconnecter</a></li>
            <li><a class="navbar-link" href="/MecaChrysalide/user/profileModify.php">Mon profil</a></li>
        <?php } ?>
        <li><a class="navbar-link" href="/MecaChrysalide/backoffice.php">Panneau de configuration
                administrateur</a></li>
    </ul>
</nav>