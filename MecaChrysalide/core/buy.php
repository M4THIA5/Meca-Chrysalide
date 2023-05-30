<?php
session_start();
require "../conf.inc.php";
require "functions.php";
redirectIfNotConnected();

$connect = connectDB();
$insertCoordonnees = $connect->prepare("INSERT INTO " . DB_PREFIX . "coordonnees 
										(nomDestinataire, prenomDestinataire, rue, ville, codePostal, telephone)
										VALUES 
										(:nomDestinataire, :prenomDestinataire, :rue, :ville, :codePostal, :telephone)");


$insertCoordonnees->execute([
    "nomDestinataire" => $_POST['nom'],
    "prenomDestinataire" => $_POST['prenom'],
    "rue" => $_POST['rue'],
    "ville" => $_POST['ville'],
    "codePostal" => $_POST['codePostal'],
    "telephone" => $_POST['telephone']
]);

$fkIdCoordonnees = $connect->lastInsertId();


$insertCommand = $connect->prepare("INSERT INTO " . DB_PREFIX . "commande 
										(fkIdUtilisateur, fkIdProduit, fkIdCoordonnees)
										VALUES 
										(:fkIdUtilisateur, :fkIdProduit, :fkIdCoordonnees)");

$insertCommand->execute([
    "fkIdUtilisateur" => $_POST['idUtilisateur'],
    "fkIdProduit" => $_POST['idProduit'],
    "fkIdCoordonnees" => $fkIdCoordonnees
]);

header("Location: ../boutique.php");

?>