<?php
session_start();
require "../conf.inc.php";
require "functions.php";
redirectIfNotConnected();

$lastname = cleanLastname($_POST["lastname"]);
$firstname = cleanFirstname($_POST["firstname"]);
$email = cleanEmail($_POST["email"]);
$pwd = $_POST["pwdActuel"];
$newPwd = $_POST["nouveauPwd"];
$newPwdConfirm = $_POST["confirmPwd"];

$listOfErrors = [];
//Vérification micro des valeurs

$connection = connectDB();
// Lastname -> >= 2 caractères
if(!empty($lastname) && strlen($lastname) < 2){
	$listOfErrors[] = "Le nom doit faire plus de 2 caractères";
}
// Firstname -> >= 2 caractères
if(!empty($firstname) && strlen($firstname) < 2){
	$listOfErrors[] = "Le prénom doit faire plus de 2 caractères";
}
// Email -> Format
if(!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL) ){
	$listOfErrors[] = "L'email est incorrect";
}else{

	// Email -> Unicité
	$queryPrepared = $connection->prepare("SELECT id FROM ".DB_PREFIX."utilisateur WHERE email=:email");
	$queryPrepared->execute([
								"email"=>$email
							]);

	$result = $queryPrepared->fetch();

	if(!empty($result)){
		$listOfErrors[] = "L'email est déjà utilisé";
	}

}




if(empty($listOfErrors))
{
	if(!empty($lastname)){
		$queryPrepared = $connection->prepare("UPDATE ".DB_PREFIX."utilisateur SET nom = :nom WHERE id = :id");
		$queryPrepared->execute(["nom"=>$lastname,
								"id"=>$_SESSION['id']
								]);
	}

	if(!empty($firstname)){
		$queryPrepared = $connection->prepare("UPDATE ".DB_PREFIX."utilisateur SET prenom = :prenom");
		$queryPrepared->execute(["prenom"=>$prenom,
								"id"=>$_SESSION['id']
								]);
	}

	if(!empty($email)){
		$queryPrepared = $connection->prepare("UPDATE ".DB_PREFIX."utilisateur SET email = :email");
		$queryPrepared->execute(["email"=>$email,
								"id"=>$_SESSION['id']
								]);
	}
	//Redirection vers la page login
	header("location: ../user/login.php");

}else{
	//SI NOK
	//Redirection sur register avec les erreurs
	$_SESSION['errors'] = $listOfErrors;
	header("location: ../user/profileModify.php");

}