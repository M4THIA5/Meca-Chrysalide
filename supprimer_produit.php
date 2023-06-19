<?php
include('conf.inc.php');
include('core/functions.php');
// Vérifier si l'administrateur est connecté et a les autorisations nécessaires

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer l'identifiant du produit à supprimer depuis le formulaire
    $produitId = $_POST['produit_id'];

    $connect = connectDB();

    // Mettre à jour la colonne "obsolete" dans la table des produits
    $query = "UPDATE " . DB_PREFIX . "produit SET obsolete = 1 WHERE idProduit = :produit_id";
    $stmt = $connect->prepare($query);
    $stmt->bindParam(':produit_id', $produitId, PDO::PARAM_INT);
    $stmt->execute();

    // Rediriger vers la page d'administration de la boutique
    header("Location: adminBoutique.php");
    exit();
} else {
    // Rediriger vers une autre page en cas de tentative d'accès direct à ce fichier sans formulaire
    header("Location: adminBoutique.php");
    exit();
}
?>