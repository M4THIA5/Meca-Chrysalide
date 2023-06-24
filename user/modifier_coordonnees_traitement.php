<?php
session_start();
require "../conf.inc.php";
require "../core/functions.php";
$idCommande = $_POST["idCommande"];

// Reste du code inchangé
$nomDestinataire = $_POST["nomDestinataire"];
$prenomDestinataire = $_POST["prenomDestinataire"];
$rue = $_POST["rue"];
$codePostal = $_POST["codePostal"];
$ville = $_POST["ville"];
$telephone = $_POST["telephone"];
$email = $_POST["email"];

$connect = connectDB();
$updateCoordonnees = $connect->prepare("
    UPDATE " . DB_PREFIX . "coordonnees
    SET nomDestinataire = :nomDestinataire,
        prenomDestinataire = :prenomDestinataire,
        rue = :rue,
        codePostal = :codePostal,
        ville = :ville,
        telephone = :telephone,
        email = :email
    WHERE idCo = (
        SELECT fkIdCoordonnees FROM " . DB_PREFIX . "commande WHERE idCommande = :commandeID
    )
");
$updateCoordonnees->execute([
    "nomDestinataire" => $nomDestinataire,
    "prenomDestinataire" => $prenomDestinataire,
    "rue" => $rue,
    "codePostal" => $codePostal,
    "ville" => $ville,
    "telephone" => $telephone,
    "email" => $email,
    "commandeID" => $idCommande
]);

// Redirigez l'utilisateur vers la page "Mon Profil" ou une autre page appropriée
header("Location: profil.php");
exit();
?>