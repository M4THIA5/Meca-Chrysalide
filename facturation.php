<?php session_start(); ?>
<?php require('core/functions.php'); ?>
<?php require('conf.inc.php'); ?>
<?php include('template/head.php'); ?>
<?php include('template/navbar.php'); ?>

<h1> Entrez vos coordonnées afin de réserver l'oeuvre</h1>
<?php $_SESSION['idProduit'] = isset($_GET["id"]) ? $_GET["id"] : ''; ?>




<ul class="fil-ariane">
    <li>
        <a href="#"><b>Facturation</b></a>
    </li>
    <li>
        <a href="#">Récapitulatif</a>
    </li>
    <li>
        <a href="#">Validation</a>
    </li>
</ul>
<section class="facturation">
    <h2> Votre commande </h2>
    <?php
    if (isset($_SESSION['errors'])) {
        foreach ($_SESSION['errors'] as $error) {
            echo '<div>' . $error;

            if (strpos($error, "Vous avez déjà passé une commande pour ce produit") !== false) {
                echo ' <a href="user/profil.php">Consulter votre profil</a>';
            }

            echo '</div>';
        }
        unset($_SESSION['errors']);
    }

    $connect = connectDB();
    $queryPrepared = $connect->prepare("SELECT * FROM " . DB_PREFIX . "produit where idProduit=:id");
    $queryPrepared->execute([
        "id" => $_GET["id"]
    ]);
    $produit = $queryPrepared->fetch();

    echo '<section> 
    <figure> <img alt="' . $produit["description"] . '" src="' . $produit["image"] . '">
                <figcaption> ' . $produit["description"] . ' </figcaption>
                <h4> Prix : ' . $produit["prix"] . ' </h4>
                </a></figure>
            
    </section>';

    ?>
    <h4> Coordonnées de livraison </h4>
    <p> Veuillez entrer vos coordonnées de livraison, Félix vous contactera bientôt ! </p>
    <?php

    echo '<form class="coordonnees" action="core/verificationCommand.php" method="POST">
        <input type="hidden" name="idUtilisateur" value="' . $_SESSION["user_id"] . '">
        <input type="hidden" name="idProduit" value="' . $_SESSION['idProduit'] . '">

                <input type="text" name="nom" placeholder="Votre nom" required="required">
                <input type="text" name="prenom" placeholder="Votre prénom" required="required">    
                <input type="text" name="rue" placeholder="Votre rue" required="required">
                <input type="text" name="codePostal" placeholder="Votre code postal" required="required">
                <input type="text" name="ville" placeholder="Votre ville" required="required">
                <input type="text" name="telephone" placeholder="Votre numéro de téléphone" required="required">
                <input type="email" name="email" placeholder="Votre email" required="required">
                <a href="core/verificationCommand.php?id=' . $_GET["id"] . '"><button type="submit">Valider</button></a>
            </form>';

    ?>
</section>

<?php include('template/footer.php'); ?>