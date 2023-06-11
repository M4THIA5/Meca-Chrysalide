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

function selectImageForCapcha() {
	// Chemin du dossier contenant les images
	$dossier = '../assets/capcha/';

	// Liste des extensions d'images autorisées
	$extensions = ['jpg', 'jpeg', 'png'];

	// Récupération de la liste des fichiers dans le dossier
	$fichiers = glob($dossier . '*.{'.implode(',', $extensions).'}', GLOB_BRACE);

	// Vérification s'il y a des images dans le dossier
	if (count($fichiers) > 0) {
		// Sélection aléatoire d'un fichier, son chemin est stocké dans la variable
		$imageCapchaAleatoire = $fichiers[array_rand($fichiers)];
		$imageCapchaAleatoire = substr($imageCapchaAleatoire, 3); // Supprime les 3 premiers caractères (../)
		$imageCapcha = "/MecaChrysalide/" . $imageCapchaAleatoire; // Concatène les deux chaînes de caractères pour obtenir le chemin absolu

		// Affichage de l'image
		echo '<img src="'.$imageCapcha.'" alt="image">';
		
		return $imageCapcha;
	} else {
		echo 'Aucune image disponible.';
	}
}

function gdImage($cheminImage) {
	$cheminImage = pathCapcha . $cheminImage;

	// Vérification si le fichier existe
	if (!file_exists($cheminImage)) {
		echo 'Le fichier image spécifié n\'existe pas.';
		return null;
	}

	// Récupération de l'extension du fichier
	$extension = pathinfo($cheminImage, PATHINFO_EXTENSION);

	// Vérification de l'extension et chargement de l'image appropriée
	switch ($extension) {
		case 'jpeg':
		case 'jpg':
			$image = imagecreatefromjpeg($cheminImage);
			break;
		case 'png':
			$image = imagecreatefrompng($cheminImage);
			break;
		case 'gif':
			$image = imagecreatefromgif($cheminImage);
			break;
		default:
			echo 'Format d\'image non pris en charge.';
			return null;
	}

	// Vérification si l'image a été créée avec succès
	if ($image === false) {
		echo 'Erreur lors de la création de l\'image.';
		return null;
	}

	// Redimensionner l'image
	$imageResized = resizeImageGD($image);

	// Envoi de l'image redimensionnée avec le bon en-tête de type MIME
	switch ($extension) {
		case 'jpeg':
		case 'jpg':
			header('Content-Type: image/jpeg');
			imagejpeg($imageResized);
			break;
		case 'png':
			header('Content-Type: image/png');
			imagepng($imageResized);
			break;
		case 'gif':
			header('Content-Type: image/gif');
			imagegif($imageResized);
			break;
		default:
			echo 'Impossible d\'afficher l\'image.';
			return null;
	}

	// Libération de la mémoire en détruisant l'image'
	imagedestroy($imageResized);

	return $image;
}


function resizeImageGD($image){
	// Redimensionner l'image
	$image_resized = imagecreatetruecolor(150, 150);
	imagecopyresampled($image_resized, $image, 0, 0, 0, 0, 150, 150, imagesx($image), imagesy($image));
	return $image_resized;
}






?>