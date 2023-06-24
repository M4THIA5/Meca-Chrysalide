<?php

function cleanLastname($lastname){
	return strtoupper(trim($lastname));
}

function cleanFirstname($firstname){
	return ucwords(strtolower(trim($firstname)));
}

function cleanEmail($email){
	return strtolower(trim($email));
}

function checkPhone($phone){
	$pattern = "/^(06|07)(([ .-])\d{2}\3\d{2}\3\d{2}\3\d{2}|(\d{2}){4})$/";
	return preg_match($pattern, $phone)===1;	//preg_match vérifie la regex renvoie un booleen 
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
	$extensions = ['jpg', 'jpeg'];

	// Récupération de la liste des fichiers dans le dossier
	$fichiers = glob($dossier . '*.{'.implode(',', $extensions).'}', GLOB_BRACE);

	// Vérification s'il y a des images dans le dossier
	if (count($fichiers) > 0) {
		// Sélection aléatoire d'un fichier, son chemin est stocké dans la variable
		$imageCapchaAleatoire = $fichiers[array_rand($fichiers)];
		$imageCapchaAleatoire = substr($imageCapchaAleatoire, 3); // Supprime les 3 premiers caractères (../)
		$imageCapcha = "/MecaChrysalide/" . $imageCapchaAleatoire; // Concatène les deux chaînes de caractères pour obtenir le chemin absolu
		
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
	$imageDecoupe = decouperImageGD($imageResized, 3, 3);
	foreach($imageDecoupe as $key=>$image){
		imagejpeg($image, pathCapcha.'/MecaChrysalide/assets/capcha/imagesDecoupe/image'.$key.'.jpg', 100);
	}
}


function resizeImageGD($image){
	// Redimensionner l'image
	$image_resized = imagecreatetruecolor(150, 150);
	imagecopyresampled($image_resized, $image, 0, 0, 0, 0, 150, 150, imagesx($image), imagesy($image));
		//imagecopyresampled(
		//$image_resized, 
		//$image, 
		//0, 0,  Les coordonnées de la position supérieure gauche dans l'image de destination où l'image source sera copiée.
		//0, 0,  Les coordonnées de la position supérieure gauche dans l'image source à partir de laquelle la copie doit commencer.
		//150, 150,  La largeur et la hauteur de la zone de destination dans l'image de destination. Dans cet exemple, l'image sera redimensionnée à une taille de 150x150 pixels.
		//imagesx($image), 
		//imagesy($image)	)

	// Libération de la mémoire en détruisant l'image
	imagedestroy($image);
	return $image_resized;
}


function decouperImageGD($image, $nbColonnes, $nbLignes) {
    // Récupération des dimensions de l'image
    $largeur = imagesx($image);
    $hauteur = imagesy($image);
    
    // Calcul de la largeur et de la hauteur d'un morceau
    $largeurMorceau = $largeur / $nbColonnes;
    $hauteurMorceau = $hauteur / $nbLignes;
    
    // Création d'un tableau pour stocker les morceaux d'image
    $morceaux = array();
    
    // Découpage de l'image en morceaux
    for ($i = 0; $i < $nbLignes; $i++) {
        for ($j = 0; $j < $nbColonnes; $j++) {
            // Création d'une nouvelle image pour le morceau
            $morceau = imagecreatetruecolor($largeurMorceau, $hauteurMorceau);
            
            // Copie du morceau de l'image d'origine dans le morceau nouvellement créé
            imagecopy($morceau, $image, 0, 0, $j * $largeurMorceau, $i * $hauteurMorceau, $largeurMorceau, $hauteurMorceau);
            
            // Ajout du morceau au tableau des morceaux
            $morceaux[] = $morceau;
        }
    }
    // Retourne le tableau contenant les morceaux d'image
    return $morceaux;
}

?>