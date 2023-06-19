<?php session_start(); ?>
<?php require('../core/functions.php'); ?>
<?php require('../conf.inc.php'); ?>
<?php include('../template/head.php'); ?>
<?php include('../template/navbar.php'); ?>
<?php redirectIfNotConnected(); ?>

<h1> Panneau de configuration administrateur </h1>

<?php
// Liste utilisateurs avec actions (supprimer / promouvoir - rétrograder)
$connect = connectDB();
$results = $connect->query("SELECT id, prenom, nom, email, anniversaire, dateInscription, droitAdmin FROM " . DB_PREFIX . "utilisateur ORDER BY id ASC");



$listOfUsers = $results->fetchAll(PDO::FETCH_ASSOC);

?>
<section class="backoffice-users">
	<h2>Utilisateurs</h2>
	<table class="panneauUtilisateurs">
		<thead>
			<tr>
				<th>Id</th>
				<th>Prénom</th>
				<th>Nom</th>
				<th>Email</th>
				<th>Date de naissance</th>
				<th>Date d'insertion</th>
				<th>Actions</th>
		</thead>
		<?php

		foreach ($listOfUsers as $user) {
			echo "<tbody><tr>";

			echo "<td>" . $user["id"] . "</td>";
			echo "<td>" . $user["prenom"] . "</td>";
			echo "<td>" . $user["nom"] . "</td>";
			echo "<td>" . $user["email"] . "</td>";
			echo "<td>" . $user["anniversaire"] . "</td>";
			echo "<td>" . $user["dateInscription"] . "</td>";
			echo "<td><a href='../core/removeUser.php?id=" . $user["id"] . "'>Supprimer</a></td>";
			echo "<td>";
			if (($user['droitAdmin'] == 1)) {
				echo "<a class='promote-link' data-id='" . $user["id"] . "' href='../core/promoteUser.php?id=" . $user["id"] . "'>Rétrograder</a>";
			} else {
				echo "<a class='promote-link' data-id='" . $user["id"] . "' href='../core/promoteUser.php?id=" . $user["id"] . "'>Promouvoir</a>";
			}
			echo "</td>";

			echo "</tr>";
		}


		?>
		</tbody>
	</table>
</section>
<!-- Liste des commandes à confirmer / refuser -->
<a href="backoffice_commandes.php">
	<h4><u>Gerer les Commandes</u></h4>
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
	<h4><u>Gerer les produits de la boutique</u></h4>
</a>

<!-- Script JS pour la confirmation de la promotion / rétrogadation : je ne pense pas que creer un autre fichier JS soit utile pour si peu de code. -->
<script>
	document.addEventListener('DOMContentLoaded', function () {
		var promoteLinks = document.getElementsByClassName('promote-link');

		Array.prototype.forEach.call(promoteLinks, function (link) {
			link.addEventListener('click', function (event) {
				event.preventDefault();

				var userId = this.getAttribute('data-id');
				var username = this.parentNode.parentNode.cells[2].textContent.trim();

				var confirmDialog = confirm("Êtes-vous sûr de vouloir changer les droits de " + username + " ?");

				if (confirmDialog) {
					window.location.href = '../core/promoteUser.php?id=' + userId;
				} else {
					return false;
				}
			});
		});
	});
</script>
<?php include('../template/footer.php'); ?>