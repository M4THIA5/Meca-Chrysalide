<?php

function cleanLastname($lastname)
{
	return strtoupper(trim($lastname));
}

function cleanFirstname($firstname)
{
	return ucwords(strtolower(trim($firstname)));
}

function cleanEmail($email)
{
	return strtolower(trim($email));
}

function connectDB()
{
	try {
		$connection = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT, DB_USER, DB_PWD);
	} catch (Exception $e) {
		die("Erreur SQL " . $e->getMessage());
	}

	return $connection;
}

function isConnected()
{

	if (!empty($_SESSION["email"]) && !empty($_SESSION["login"])) {

		$connect = connectDB();
		$queryPrepared = $connect->prepare("SELECT id FROM " . DB_PREFIX . "utilisateur WHERE email=:email");
		$queryPrepared->execute(["email" => $_SESSION["email"]]);
		$result = $queryPrepared->fetch();
		//Si l'email que l'on a en session existe aussi dans la bdd
		//alors on part du principe que l'utilisateur est bien connecté
		return !empty($result);
	}
	return false;
}

function redirectIfNotConnected()
{
	if (!isConnected()) {
		header("Location: /MecaChrysalide/user/login.php");
	}
}
function generateSortLink($text, $sortKey)
{
	$_GET['sort'] = isset($_GET['sort']) ? $_GET['sort'] : 'idCommande';
	$_GET['order'] = isset($_GET['order']) && $_GET['order'] === 'desc' ? 'DESC' : 'ASC';

	$order = $_GET['sort'] === $sortKey && $_GET['order'] === 'asc' ? 'desc' : 'asc';
	$url = "backoffice_commandes.php?sort=$sortKey&order=$order";
	return "<a href=\"$url\">$text</a>";
}
?>