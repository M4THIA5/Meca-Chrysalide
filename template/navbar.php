<nav>
    <ul>
        <li><a class="navbar-link" href="/Meca-Chrysalide-main/index.php">Home</a></li>
        <li><a class="navbar-link" href="/Meca-Chrysalide-main/apropos.php">A Propos</a></li>
        <li><a class="navbar-link" href="/Meca-Chrysalide-main/boutique.php">Boutique</a></li>
        <li><a class="navbar-link" href="/Meca-Chrysalide-main/events.php">Evènements</a></li>
        <?php if (!isConnected()) { ?>
            <li><a class="navbar-link" href="/Meca-Chrysalide-main/user/register.php">S'inscrire</a></li>
            <li><a class="navbar-link" href="/Meca-Chrysalide-main/user/login.php">Se connecter</a></li>
        <?php } else { ?>
            <li><a class="navbar-link" href="/Meca-Chrysalide-main/user/logout.php">Se déconnecter</a></li>
        <?php } ?>
        <li><a class="navbar-link" href="/Meca-Chrysalide-main/backoffice.php">Panneau de configuration
                administrateur</a></li>
    </ul>
</nav>