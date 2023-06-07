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

function selectImageForCapcha(){
	// Chemin du dossier contenant les images
	$dossier = '../assets/capcha/';

	// Liste des extensions d'images autorisées
	$extensions = ['jpg', 'jpeg', 'png'];

	// Récupération de la liste des fichiers dans le dossier
	$fichiers = glob($dossier . '*.{'.implode(',', $extensions).'}', GLOB_BRACE);

	// Vérification s'il y a des images dans le dossier
	if (count($fichiers) > 0) {
		// Sélection aléatoire d'un fichier,, son chemin est stocké dans la variable
		$imageCapchaAleatoire = $fichiers[array_rand($fichiers)];
		$imageCapchaAleatoire = substr($imageCapchaAleatoire,3);	//supprime les 3 premiers caractères (../)
		$imageCapcha= "/MecaChrysalide/";
		$imageCapcha .= $imageCapchaAleatoire;	//concatène les deux chaînes de caractères pour obtenir le chemin absolu
		return $imageCapcha;
	} else {
		echo 'Aucune image disponible.';
	}
}

function cutImageForCapcha($imagePath){

	echo '<img src="'.$imagePath.'" alt="image">';
	// Chargement de l'image
	$image = imagecreatefromjpeg($imagePath);

	// Dimensions de l'image
	$largeur = 150;
	$hauteur = 150;
	$image = imagecreatetruecolor($largeur, $hauteur);

	// Dimensions des morceaux
	$largeurMorceau = $largeur / 3;
	$hauteurMorceau = $hauteur / 3;

	// Découpage et enregistrement des morceaux
	for ($i = 0; $i < 3; $i++) {
		for ($j = 0; $j < 3; $j++) {
			// Création du morceau
			$morceau = imagecreatetruecolor($largeurMorceau, $hauteurMorceau);
			echo '<img src="'.$morceau.'" alt="morceau image">';
		}
	}
}

?>