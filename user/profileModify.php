<?php
session_start();
require('../core/functions.php');
require('../conf.inc.php');
include('../template/head.php');
include('../template/navbar.php');
redirectIfNotConnected();

$connect = connectDB();
$queryPrepared = $connect->prepare("SELECT nom, prenom, email, anniversaire, telephone, dateInscription FROM " . DB_PREFIX . "utilisateur WHERE email=:email");
$queryPrepared->execute(["email" => $_SESSION["email"]]);
$profil = $queryPrepared->fetch();
?>

<h1>MODIFIER MON PROFIL</h1>
<h3> Veuillez renseigner tout les champs afin de modifier votre profil, si vous ne voulez modifier qu'un champ, remettez
	les mêmes informations dans les autres champs. Les champs mot de passes peuvent être laissé vides.</h3>

<form action="modifyUser.php" method="POST">
	<div class="modifyProfil">
		<table>
			<tbody>
				<tr>
					<th>Prénom</th>
					<td><input type="text" name="firstname" id="firstname"
							placeholder="<?php echo $profil['prenom']; ?>">
					</td>
				</tr>
				<tr>
					<th>Nom</th>
					<td><input type="text" name="lastname" id="lastname" placeholder="<?php echo $profil['nom']; ?>">
					</td>
				</tr>
				<tr>
					<th>Email</th>
					<td><input type="email" name="email" placeholder="<?php echo $profil['email']; ?>"></td>
				</tr>
				<tr>
					<th>Date de naissance</th>
					<td>
						<input type="text" name="anniversaire" placeholder="<?php echo $profil['anniversaire']; ?>"
							onfocus="this.type='date'" onblur="this.type='text'">
					</td>
				</tr>
				<tr>
					<th>Téléphone</th>
					<td>
						<?php if (empty($profil["telephone"])) { ?>
							<input type="tel" name="telephone" placeholder="Ajouter un numéro de téléphone">
						<?php } else { ?>
							<?php echo '<input type="tel" name="telephone" placeholder="' . $profil["telephone"] . '">'; ?>

						<?php } ?>
					</td>
				</tr>
				<tr>
					<th>Mot de passe actuel</th>
					<td><input class="form-control" type="password" name="pwdActuel" id="mdpActuel"></td>
				</tr>
				<tr>
					<th>Nouveau mot de passe</th>
					<td><input class="form-control" type="password" name="nouveauPwd" id="nouveauMdp"></td>
				</tr>
				<tr>
					<th>Confirmer le nouveau mot de passe</th>
					<td><input class="form-control" type="password" name="confirmPwd" id="confirmMdp"></td>
				</tr>
				<tr>
					<th>Date d'inscription</th>
					<td>
						<?php echo $profil["dateInscription"]; ?>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<label>
		<button type="submit">Valider les modifications</button>
	</label>
</form>
<?php
include('../template/footer.php');
?>