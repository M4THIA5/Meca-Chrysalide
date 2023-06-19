<?php
session_start();
require('core/functions.php');
require('conf.inc.php');

// Vérifier si l'administrateur est connecté et a les autorisations nécessaires

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer l'identifiant du produit à rétablir depuis le formulaire
    $produitId = $_POST['produit_id'];
    $connect = connectDB();

    // Mettre à jour la colonne "obsolete" dans la table des produits
    $queryRetaBLirProduit = "UPDATE " . DB_PREFIX . "produit SET obsolete = 0 WHERE idProduit = :produit_id";
    $stmtRetaBLirProduit = $connect->prepare($queryRetaBLirProduit);
    $stmtRetaBLirProduit->bindParam(':produit_id', $produitId, PDO::PARAM_INT);
    $stmtRetaBLirProduit->execute();

    header("Location: backoffice/adminBoutique.php");
    exit();
} else {

    header("Location: backoffice/adminBoutique.php");
    exit();
}
?>