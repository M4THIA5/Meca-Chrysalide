<?php session_start();
require('core/functions.php');
require('conf.inc.php');
include('template/head.php');
include('template/navbar.php'); 
redirectIfNotConnected();
?>

<h1> Panneau de configuration administrateur </h1>

<?php

	$connect = connectDB();
	$results = $connect->query("SELECT * FROM ".DB_PREFIX."utilisateur");

	$listOfUsers = $results->fetchAll();

?>

	<table class="table">
		<thead>
			<tr>
				<th>Id</th>
				<th>Prénom</th>
				<th>Nom</th>
				<th>Email</th>
				<th>Date de naissance</th>
				<th>Date d'insertion</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php

				foreach($listOfUsers as $user){
					echo "<tr>";

					echo "<td>".$user["id"]."</td>";
					echo "<td>".$user["prenom"]."</td>";
					echo "<td>".$user["nom"]."</td>";
					echo "<td>".$user["email"]."</td>";
					echo "<td>".$user["anniversaire"]."</td>";
					echo "<td>".$user["dateInscription"]."</td>";
					echo "<td><a href='core/removeUser.php?id=".$user["id"]."' class='btn btn-danger'>Supprimer</a></td>";

					echo "</tr>";
				}
				print_r($user);
			?>
		</tbody>
	</table>

<?php include('template/footer.php'); ?>