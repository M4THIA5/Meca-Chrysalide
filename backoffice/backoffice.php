<?php
session_start();
require_once('../core/functions.php');
require_once('../conf.inc.php');
include_once('../template/head.php');
include_once('../template/navbar.php');
redirectIfNotConnected();
?>

<h1> Panneau de configuration administrateur </h1>

<!-- Liste des utilisateurs à promouvoir / rétrograder -->
<a href="backoffice_users.php">
	<h4><u>Gérer les utilisateurs</u></h4>
</a>

<!-- Liste des commandes à confirmer / refuser -->
<a href="backoffice_commandes.php">
	<h4><u>Gérer les commandes</u></h4>
</a>
<!-- Liste des commentaires à valider / supprimer -->
<a href="signalements.php">
	<h4><u>Signalements de commentaires</u></h4>
</a>
<!-- Liste des produits à ajouter / supprimer -->
<a href="addProduct.php">
	<h4><u>Ajouter des produits à la boutique</u></h4>
</a>
<a href="adminBoutique.php">
	<h4><u>Gérer les produits de la boutique</u></h4>
</a>

<!-- Script JS pour la confirmation de la promotion / rétrogradation -->


<?php
include_once('../template/footer.php');
?>