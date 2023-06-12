<?php session_start(); ?>
<?php require('core/functions.php'); ?>
<?php require('conf.inc.php'); ?>
<?php include('template/head.php'); ?>
<?php include('template/navbar.php'); ?>

<h1> Recapitulatif </h1>

<ul class="fil-ariane">

    <a href="#">Facturation</a>


    <a href="#"><b>Récapitulatif</b></a>


    <a href="#">Validation</a>

</ul>

<section class="recapfacturation">
    <h2> Votre commande </h2>
    <?php echo 'Article numéro : ' . $_SESSION['idProduit'] . '<br> 
    Nom : ' . $_SESSION['nom'] . '<br>
 Prénom : ' . $_SESSION['prenom'] . '<br>
 Adresse : ' . $_SESSION['rue'] . '<br>
    Code postal : ' . $_SESSION['codePostal'] . '<br>
    Ville : ' . $_SESSION['ville'] . '<br>
    Téléphone : ' . $_SESSION['telephone'] . '<br>
    Email : ' . $_SESSION['email'] . '<br>'; ?>
    <a href="core/buy.php"><button type="button">Valider la
            commande</button></a>

</section>

<?php include('template/footer.php'); ?>