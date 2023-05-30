<?php session_start(); ?>
<?php require('../core/functions.php'); ?>
<?php require('../conf.inc.php'); ?>
<?php include('../template/head.php'); ?>
<?php include('../template/navbar.php'); ?>

<h1 class="registertitle"> S'inscrire </h1>
<div class="register">
    <div>

        <div>
            <?php
            if (isset($_SESSION['errors'])) {
                foreach ($_SESSION['errors'] as $error) {
                    echo '<div>' . $error . '</div>';
                }
                unset($_SESSION['errors']);
            }
            ?>

            <form action="../core/registerUser.php" method="POST">
                <input class="form-control" name="lastname" id="lastname" placeholder="Votre Nom" required="required">
                <input class="form-control" name="firstname" id="firstname" placeholder="Votre prénom"
                    required="required">

                <label for="birthday" class="form-label">
                    Votre date de naissance :
                </label>

                <input class="form-control" type="date" id="birthday" name="birthday"
                    placeholder="Votre date de naissance" required="required">
        </div>
        <div class="col-md-6">
            <input class="form-control" type="email" name="email" placeholder="Votre email" required="required">

            <input class="form-control" type="password" name="pwd" id="pwd" placeholder="Votre mot de passe"
                required="required">

            <input class="form-control" type="password" name="pwdConfirmation" id="pwdConfirmation"
                placeholder="Confirmez votre mot de passe" required="required">

            <label for="cgu">J'accepte les CGU
                <a href="cgu.php" target="_blank">(Conditions Générales d'Utilisation)</a>

            </label>
            <input class="form-check-input" type="checkbox" name="cgu" id="cgu">
            <label>
                <button>S'inscrire</button>
            </label>
            </form>
        </div>
    </div>
</div>
<div>
    <p>
        Vous êtes déjà inscrit ? <a href="../login.php"><u>Connectez-vous</u></a>
    </p>
</div>
<?php include('../template/footer.php'); ?>