<?php session_start(); ?>
<?php require('../core/functions.php'); ?>
<?php require('../conf.inc.php'); ?>
<?php include('../template/head.php'); ?>
<?php include('../template/navbar.php'); 
redirectIfNotConnected();?>

<h1>MON PROFIL</h1>

<?php

	$connect = connectDB();
	$queryPrepared = $connect->prepare("SELECT nom, prenom, email, anniversaire, telephone, dateInscription FROM ".DB_PREFIX."utilisateur WHERE email=:email" );
    $queryPrepared->execute(["email"=>$_SESSION["email"]]);
	$myUser = $queryPrepared->fetchAll();
?>
	<table class="table">
			<thead>
				<tr>
					<th>Prénom</th>
					<th>Nom</th>
					<th>Email</th>
					<th>Date de naissance</th>
					<th>Téléphone</th>
					<th>Date d'inscription</th>
				</tr>
			</thead>
			<tbody>
			<?php

				foreach($myUser as $profile){
					echo "<tr>";
					echo "<td>".$profile["nom"]."</td>";
					echo "<td>".$profile['prenom']."</td>";
					echo "<td>".$profile['email']."</td>";
					echo "<td>".$profile["anniversaire"]."</td>";
					if(empty($profile["telephone"])){
						echo "<td> Ajouter un numéro de téléphone </td>";
					}else{
						echo "<td>".$profile["telephone"]."</td>";
					}
					echo "<td>".$profile["dateInscription"]."</td>";
				}
			?>
				</tr>
			</tbody>
		</table>
	<label>
        <button class="btn btn-primary">Valider les modifications</button>
    </label>

<?php include('../template/footer.php'); ?>