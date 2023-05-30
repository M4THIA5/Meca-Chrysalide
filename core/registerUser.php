<?php
session_start();
require "../conf.inc.php";
require "functions.php";



if (
	count($_POST) != 7
	|| empty($_POST["lastname"])
	|| empty($_POST["firstname"])
	|| empty($_POST["birthday"])
	|| empty($_POST["email"])
	|| empty($_POST["pwd"])
	|| empty($_POST["pwdConfirmation"])
	|| empty($_POST["cgu"])
) {
	die("Tentative de HACK !!!!");
}


$lastname = cleanLastname($_POST["lastname"]);
$firstname = cleanFirstname($_POST["firstname"]);
$email = cleanEmail($_POST["email"]);
$pwd = $_POST["pwd"];
$pwdConfirm = $_POST["pwdConfirmation"];
$anniversaire = $_POST["birthday"];


$listOfErrors = [];
//Vérification micro des valeurs

// Lastname -> >= 2 caractères
if (strlen($lastname) < 2) {
	$listOfErrors[] = "Le nom doit faire plus de 2 caractères";
}
// Firstname -> >= 2 caractères
if (strlen($firstname) < 2) {
	$listOfErrors[] = "Le prénom doit faire plus de 2 caractères";
}
// Email -> Format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	$listOfErrors[] = "L'email est incorrect";
} else {

	// Email -> Unicité
	$connection = connectDB();
	$queryPrepared = $connection->prepare("SELECT id FROM " . DB_PREFIX . "utilisateur WHERE email=:email");
	$queryPrepared->execute([
		"email" => $email
	]);

	$result = $queryPrepared->fetch();

	if (!empty($result)) {
		$listOfErrors[] = "L'email est déjà utilisé";
	}

}


// Date de naissance -> entre 6 et 80
//echo $anniversaire; // 1986-11-29

$anniversaireExploded = explode("-", $anniversaire);

if (!checkdate($anniversaireExploded[1], $anniversaireExploded[2], $anniversaireExploded[0])) {
	$listOfErrors[] = "Format de date incorrect";
} else {
	$todaySecond = time();
	$anniversaireSecond = strtotime($anniversaire);
	$ageSecond = $todaySecond - $anniversaireSecond;
	$age = $ageSecond / 60 / 60 / 24 / 365.25;
	if ($age < 6 || $age > 80) {
		$listOfErrors[] = "Vous n'avez pas l'âge requis";
	}
}


// Pwd -> Min 8 caractères avec minuscules majuscules et chiffres
if (
	strlen($pwd) < 8 ||
	!preg_match("#[a-z]#", $pwd) ||
	!preg_match("#[A-Z]#", $pwd) ||
	!preg_match("#[0-9]#", $pwd)
) {

	$listOfErrors[] = "Votre mot de passe doit faire au minimum 8 caractères avec des minuscules, des majuscules et des chiifres";
}


//pwdConfirm -> = Pwd
if ($pwd != $pwdConfirm) {
	$listOfErrors[] = "Votre mot de passe de confirmation ne correspond pas";
}

/*
// Étape 2 : Générer un code de validation unique
$codeValidation = md5(uniqid());

// Étape 3 : Enregistrer le code de validation dans la base de données ou tout autre système de stockage associé à l'utilisateur

// Étape 4 : Préparer l'email de validation
$destinataire = $email;
$sujet = "Validation de votre compte";
$message = "Bienvenue sur notre site ! Veuillez cliquer sur le lien suivant pour valider votre compte : <a href='http://www.example.com/validation.php?code=$codeValidation'>Valider mon compte</a>";

$headers = "From: votreadresse@example.com\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

// Étape 5 : Envoyer l'email de validation
if (mail($destinataire, $sujet, $message, $headers)) {
	echo "Un email de validation a été envoyé à votre adresse email. Veuillez vérifier votre boîte de réception.";
} else {
	echo "Une erreur s'est produite lors de l'envoi de l'email de validation.";
}
*/


if (empty($listOfErrors)) {
	//SI OK
	//Insertion du USER
	$queryPrepared = $connection->prepare("INSERT INTO " . DB_PREFIX . "utilisateur 
										(prenom, nom, email, mdp, anniversaire, droitAdmin)
										VALUES 
										(:prenom, :nom, :email, :mdp, :anniversaire, 0)");

	$queryPrepared->execute([
		"prenom" => $firstname,
		"nom" => $lastname,
		"email" => $email,
		"mdp" => password_hash($pwd, PASSWORD_DEFAULT),
		"anniversaire" => $anniversaire,
	]);

	//Redirection vers la page login
	header("location: ../user/login.php");

} else {
	//SI NOK
	//Redirection sur register avec les erreurs
	$_SESSION['errors'] = $listOfErrors;
	header("location: ../user/register.php");

}

?>