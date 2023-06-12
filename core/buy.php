<?php
session_start();
require "../conf.inc.php";
require "functions.php";

$connect = connectDB();
$insertCoordonnees = $connect->prepare("INSERT INTO " . DB_PREFIX . "coordonnees 
										(nomDestinataire, prenomDestinataire, rue, ville, codePostal, telephone, email)
										VALUES 
										(:nomDestinataire, :prenomDestinataire, :rue, :ville, :codePostal, :telephone, :email)");


$insertCoordonnees->execute([
    "nomDestinataire" => $_SESSION['nom'],
    "prenomDestinataire" => $_SESSION['prenom'],
    "rue" => $_SESSION['rue'],
    "ville" => $_SESSION['ville'],
    "codePostal" => $_SESSION['codePostal'],
    "telephone" => $_SESSION['telephone'],
    "email" => $_SESSION['email']

]);

$fkIdCoordonnees = $connect->lastInsertId();


$insertCommand = $connect->prepare("INSERT INTO " . DB_PREFIX . "commande 
										(fkIdUtilisateur, fkIdProduit, fkIdCoordonnees, est_acceptee)
										VALUES 
										(:fkIdUtilisateur, :fkIdProduit, :fkIdCoordonnees, 0)");

$insertCommand->execute([
    "fkIdUtilisateur" => $_SESSION['user_id'],
    "fkIdProduit" => $_SESSION['idProduit'],
    "fkIdCoordonnees" => $fkIdCoordonnees
]);

header("Location: ../confirmfacture.php");
exit();

?>