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
	$profil = $queryPrepared->fetch();
?>

<?php if (isset($_SESSION['errors'])) {
            foreach ($_SESSION['errors'] as $error) {
                echo '<div>' . $error . '</div>';
            }
            unset($_SESSION['errors']);
        }
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
					<th>Mot de passe actuel</th>
					<th>nouveau mot de passe</th>
					<th>confirmer le nouveau mot de passe</th>
					<th>Date d'inscription</th>
				</tr>
			</thead>
			<tbody>
				<tr>
				<?php
					echo "<td> <input class='form-control' type='text' name='firstname' id='firstname' placeholder=".$profil['prenom']."></td>";
					echo "<td> <input class='form-control' type='text' name='lastname' id='lastename' placeholder=".$profil['nom']."></td>";
					echo "<td> <input class='form-control' type='email' name='email' id='email' placeholder=".$profil['email']."></td>";
					echo "<td>".$profil["anniversaire"]."</td>";
					if(empty($profil["telephone"])){
						echo "<td><input class='form-control' type='text' name='telephone' id='telephone' placeholder='Ajoutez un numéro'></td>";
					}else{
						echo "<td> <input class='form-control' type='text' name='telephone' id='telephone' placeholder=".$profil['telephone']."></td>";
					}
				?>
						<td><input class="form-control" type="password" name="pwdActuel" id="mdpActuel" ></td>
						<td><input class="form-control" type="password" name="nouveauPwd" id="nouveauMdp" ></td>
						<td><input class="form-control" type="password" name="confirmPwd" id="confirmMdp" ></td>
				<?php echo "<td>".$profil["dateInscription"]."</td>";?>
				</tr>
			</tbody>
		</table>
	<label>
        <button class="btn btn-primary">Valider les modifications</button>
    </label>
</form>
<?php include('../template/footer.php'); ?>