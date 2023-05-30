<?php
session_start();
require "../conf.inc.php";
require "functions.php";
redirectIfNotConnected();


print_r($_POST);

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
if(empty($lastname)){
	$lastname = $_SESSION["lastname"];
}elseif(strlen($lastname) < 2){
	$listOfErrors[] = "Le nom doit faire plus de 2 caractères";
}
// Firstname -> >= 2 caractères
if(empty($firstname)){
	$firstname = $_SESSION["firtname"];
}elseif(strlen($firstname) < 2){
	$listOfErrors[] = "Le prénom doit faire plus de 2 caractères";
}
// Email -> Format
if(empty($email)){
	$email = $_SESSION["email"];
}else{
	if( !filter_var($email, FILTER_VALIDATE_EMAIL) ){
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
}





if( empty($listOfErrors))
{
	//SI OK
	//Insertion du USER
	$queryPrepared = $connection->prepare("UPDATE".DB_PREFIX."utilisateur SET 
                                        prenom = :prenom,
                                        nom = :nom,
                                        email = :email
                                        /*mdp = :mdp,*/
                                        /*telephone = :telephone*/"
                                        );

	$queryPrepared->execute([
								"prenom"=>$firstname,
								"nom"=>$lastname,
								"email"=>$email
								//"mdp"=>password_hash($pwd, PASSWORD_DEFAULT),
							]);

	//Redirection vers la page login
	header("location: ../user/login.php");

}else{
	//SI NOK
	//Redirection sur register avec les erreurs
	$_SESSION['errors'] = $listOfErrors;
	header("location: ../user/register.php");

}