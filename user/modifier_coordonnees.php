<?php
session_start();
include_once('../core/functions.php');
require_once('../conf.inc.php');
include_once('../template/head.php');
include_once('../template/navbar.php');

$idCommande = $_GET["idCommande"];
// Récupérer les anciennes coordonnées de la commande
$connect = connectDB();
$queryPrepared = $connect->prepare("
    SELECT * FROM " . DB_PREFIX . "coordonnees WHERE idCo = (
        SELECT fkIdCoordonnees FROM " . DB_PREFIX . "commande WHERE idCommande = :idCommande
    )
");
$queryPrepared->execute([
    "idCommande" => $idCommande
]);
$anciennesCoordonnees = $queryPrepared->fetch(PDO::FETCH_ASSOC);
//Afficher les anciennes coordonées saisies par l'utilisateur
echo '<form class="coordonnees" action="modifier_coordonnees_traitement.php" method="post">
    <input type="hidden" name="idCommande" value="' . $idCommande . '">
    <label for="nomDestinataire">Nom :</label>
    <input type="text" name="nomDestinataire" value="' . $anciennesCoordonnees["nomDestinataire"] . '">
    <label for="prenomDestinataire">Prénom :</label>
    <input type="text" name="prenomDestinataire" value="' . $anciennesCoordonnees["prenomDestinataire"] . '">
    <label for="rue"> Rue :</label>
    <input type="text" name="rue" value="' . $anciennesCoordonnees["rue"] . '">
    <label for="codePostal">Code Postal :</label>
    <input type="text" name="codePostal" value="' . $anciennesCoordonnees["codePostal"] . '">
    <label for="ville">Ville :</label>
    <input type="text" name="ville" value="' . $anciennesCoordonnees["ville"] . '">
    <label for="telephone">Téléphone :</label>
    <input type="text" name="telephone" value="' . $anciennesCoordonnees["telephone"] . '">
    <label for="email">Email :</label>
    <input type="text" name="email" value="' . $anciennesCoordonnees["email"] . '">

    <button type="submit">Confirmer</button>
</form>';