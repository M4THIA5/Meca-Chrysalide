<?php
session_start();
require "../conf.inc.php";
require "functions.php";

if (
    count($_POST) != 9
    || empty($_POST["nom"])
    || empty($_POST["prenom"])
    || empty($_POST["rue"])
    || empty($_POST["ville"])
    || empty($_POST["codePostal"])
    || empty($_POST["telephone"])
    || empty($_POST["email"])
) {
    die("Il doit y avoir une erreur");
}


$lastname = cleanLastname($_POST["nom"]);
$firstname = cleanFirstname($_POST["prenom"]);
$email = cleanEmail($_POST["email"]);
$rue = ($_POST["rue"]);
$ville = ($_POST["ville"]);
$codePostal = ($_POST["codePostal"]);
$telephone = ($_POST["telephone"]);
$idUtilisateur = $_POST["idUtilisateur"];
$idProduit = $_POST["idProduit"];



$listOfErrors = [];
$_SESSION['errors'] = $listOfErrors;

//verification du code postal :
if (strlen($codePostal) !== 5) {
    $listOfErrors[] = "Le code postal doit comporter 5 caractères.";
    $_SESSION['errors'] = $listOfErrors;
    header("Location: ../facturation.php?id=" . $_POST['idProduit']);
    exit;
}

//verification du telephone :
if (!preg_match('/^0[167][0-9 .-]+$/', $telephone)) {
    $listOfErrors[] = "Le numéro de téléphone est invalide. Veuillez séparer par des espaces, des points ou des tirets.";
    $_SESSION['errors'] = $listOfErrors;
    header("Location: ../facturation.php?id=" . $_POST['idProduit']);
    exit;
}

//verification de l'email : 
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $listOfErrors[] = "L'email est invalide.";
    $_SESSION['errors'] = $listOfErrors;
    header("Location: ../facturation.php?id=" . $_POST['idProduit']);
    exit;
}

// verification si l'utilisateur a déja passé une commande pour ce produit : 
$connect = connectDB();
$queryPrepared = $connect->prepare("SELECT COUNT(*) AS count FROM " . DB_PREFIX . "commande WHERE fkIdUtilisateur = :idUtilisateur AND fkIdProduit = :idProduit");
$queryPrepared->execute([
    "idUtilisateur" => $idUtilisateur,
    "idProduit" => $idProduit
]);
$result = $queryPrepared->fetch();

if ($result['count'] > 0) {
    $listOfErrors[] = "Vous avez déjà passé une commande pour ce produit. Consultez votre profil dans la partie 'Mes commandes'";

    $_SESSION['errors'] = $listOfErrors;
    header("Location: ../facturation.php?id=" . $_POST['idProduit']);
    exit;
}

if (empty($listOfErrors)) {
    header("location: ../recapfacture.php");
    $_SESSION["nom"] = $lastname;
    $_SESSION["prenom"] = $firstname;
    $_SESSION["email"] = $email;
    $_SESSION["rue"] = $rue;
    $_SESSION["ville"] = $ville;
    $_SESSION["codePostal"] = $codePostal;
    $_SESSION["telephone"] = $telephone;
    $_SESSION["idProduit"] = $idProduit;
} else {
    $_SESSION['errors'] = $listOfErrors;
    header("location: ../facturation.php");
}