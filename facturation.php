<?php session_start(); ?>
<?php require('core/functions.php'); ?>
<?php require('conf.inc.php'); ?>
<?php include('template/head.php'); ?>
<?php include('template/navbar.php'); ?>

<h1> Entrez vos coordonnées </h1>



<ul class="fil-ariane">
    <li>
        <a href="#">Facturation</a>
    </li>
    <li>
        <a href="#">Paiement</a>
    </li>
    <li>
        <a href="#">Validation</a>
    </li>
</ul>
<section class="facturation">
    <h2> Votre commande </h2>
    <?php
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

    echo '<form class="coordonnees" action="core/buy.php" method="POST">
        <input type="hidden" name="idUtilisateur" value="' . $_SESSION["id"] . '">
        <input type="hidden" name="idProduit" value="' . $_GET["id"] . '">
                <input type="text" name="nom" placeholder="Votre nom" required="required">
                <input type="text" name="prenom" placeholder="Votre prénom" required="required">    
                <input type="text" name="rue" placeholder="Votre rue" required="required">
                <input type="text" name="codePostal" placeholder="Votre code postal" required="required">
                <input type="text" name="ville" placeholder="Votre ville" required="required">
                <input type="text" name="telephone" placeholder="Votre numéro de téléphone" required="required">

                <button type="submit">Valider</button>
            </form>';

    ?>
</section>

<?php include('template/footer.php'); ?>