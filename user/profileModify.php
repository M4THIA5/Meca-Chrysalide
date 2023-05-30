<?php 
session_start();
require('../core/functions.php');
require('../conf.inc.php');
include('../template/head.php');
include('../template/navbar.php');
redirectIfNotConnected();
?>

<h1> MODIFIER MON PROFILE </h1>

<?php

	$connect = connectDB();
	$queryPrepared = $connect->prepare("SELECT nom, prenom, email, anniversaire, telephone, dateInscription FROM ".DB_PREFIX."utilisateur WHERE email=:email" );
    $queryPrepared->execute(["email"=>$_SESSION["email"]]);
	$myUser = $queryPrepared->fetchAll();
?>

<form action="../core/modifyUser.php" method="POST">

	<table class="table">
			<thead>
				<tr>
					<th>Prénom</th>
					<th>Nom</th>
					<th>Email</th>
					<th>Date de naissance</th>
					<th>Téléphone</th>
					<th>Date d'inscription</th>
					<th>Mot de passe actuel</th>
					<th>nouveau mot de passe</th>
					<th>confirmer le nouveau mot de passe</th>
				</tr>
			</thead>
			<tbody>
			<?php

				foreach($myUser as $profile){
					echo "<tr>";
					echo "<td> <input class='form-control' type='text' name='lastname' id='lastname' placeholder=".$profile["nom"]."> </td>";
					echo "<td> <input class='form-control' type='text' name='firstname' id='firstname' placeholder=".$profile['prenom']."></td>";
					echo "<td> <input class='form-control' type='email' name='email' placeholder=".$profile['email']."></td>";
					echo "<td>".$profile["anniversaire"]."</td>";
					if(empty($profile["telephone"])){
						echo "<td> Ajouter un numéro de téléphone </td>";
					}else{
						echo "<td>".$profile["telephone"]."</td>";
					}
					echo "<td>".$profile["dateInscription"]."</td>";
				}
			?>
					<td><input class="form-control" type="text" name="pwdActuel" id="mdpActuel" ></td>
					<td><input class="form-control" type="text" name="nouveauPwd" id="nouveauMdp" ></td>
					<td><input class="form-control" type="text" name="confirmPwd" id="confirmMdp" ></td>
				</tr>
			</tbody>
		</table>
	<label>
        <button class="btn btn-primary">Valider les modifications</button>
    </label>
</form>
<?php include('../template/footer.php'); ?>