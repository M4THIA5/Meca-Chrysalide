<?php
session_start();
require "../conf.inc.php";
require "functions.php";
redirectIfNotConnected();
$lastname = cleanLastname($_POST["lastname"]);
$firstname = cleanFirstname($_POST["firstname"]);
$email = cleanEmail($_POST["email"]);
$phone = $_POST["telephone"];
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
	print_r($result);
	if(!isset($result)){
		if ($result['id']!=$_SESSION['user_id']){
			$listOfErrors[] = "L'email est déjà utilisé";
		}
	}

}
//Phone -> Format
if(!empty($phone)&& !checkPhone($phone)){
	$listOfErrors[] = "Le numéro de téléphone n'est pas valide";
}


if(empty($listOfErrors))
{
	if(!empty($lastname)){
		$queryPrepared = $connection->prepare("UPDATE ".DB_PREFIX."utilisateur SET nom = :nom WHERE id = :id");
		$queryPrepared->execute(["nom"=>$lastname,
								"id"=>$_SESSION['user_id']
								]);
	}

	if(!empty($firstname)){
		$queryPrepared = $connection->prepare("UPDATE ".DB_PREFIX."utilisateur SET prenom = :prenom WHERE id = :id");
		$queryPrepared->execute(["prenom"=>$firstname,
								"id"=>$_SESSION['user_id']
								]);
	}

	if(!empty($email)){
		$queryPrepared = $connection->prepare("UPDATE ".DB_PREFIX."utilisateur SET email = :email WHERE id = :id");
		$queryPrepared->execute(["email"=>$email,
								"id"=>$_SESSION['user_id']
								]);
	}

	if(!empty($phone)){
		$queryPrepared = $connection->prepare("UPDATE ".DB_PREFIX."utilisateur SET telephone = :telephone WHERE id = :id");
		$queryPrepared->execute(["telephone"=>$phone,
								"id"=>$_SESSION['user_id']
								]);
	}

	//ajout changement de mdp
	if(!empty($_POST["pwdActuel"])) {

		$pwd = $_POST['pwdActuel'];

		$queryPrepared = $connection->prepare("SELECT mdp FROM " . DB_PREFIX . "utilisateur WHERE id=:id");
		$queryPrepared->execute(["id" => $_SESSION['user_id']]);
		$result = $queryPrepared->fetch();
		if (empty($result)) {
			$listOfErrors[] = "Vérifiez que le mot de passe actuel est valide, ou que le nouveau mot de passe à correctement été entré.";
		} else{
			if($newPwd==$newPwdConfirm){
				$queryPrepared = $connection->prepare("UPDATE ".DB_PREFIX."utilisateur SET mdp = :mdp WHERE id = :id");
				$queryPrepared->execute(["mdp" => password_hash($newPwd, PASSWORD_DEFAULT),
										"id" => $_SESSION['user_id']]);
				header("location: ../user/login.php");
			}else{
				$listOfErrors[] = "Vérifiez que le mot de passe actuel est valide, ou que le nouveau mot de passe à correctement été entré.";
			}
		}
	}
	$_SESSION['errors'] = $listOfErrors;
	header("location: ../user/profileModify.php");
}else{
	//SI NOK
	//Redirection sur register avec les erreurs
	$_SESSION['errors'] = $listOfErrors;
	//header("location: ../user/profileModify.php");
}