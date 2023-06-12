<?php
session_start();
require_once('core/functions.php');
require_once('conf.inc.php');
redirectIfNotConnected();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $connect = connectDB();
    $produitId = $_POST['produitId'];

    // Vérifier si le produit existe
    $queryPrepared = $connect->prepare("
        SELECT idProduit, nbVote
        FROM " . DB_PREFIX . "produit
        WHERE idProduit = :produitId
    ");
    $queryPrepared->execute(['produitId' => $produitId]);
    $produit = $queryPrepared->fetch();

    if ($produit) {
        // Vérifier si l'utilisateur a déjà voté pour ce produit
        $hasVoted = isset($_SESSION['votes'][$produitId]);
        if ($hasVoted) {
            // Mettre à jour le nombre de votes
            $newVoteCount = $produit['nbVote'] - 1;
            $queryPrepared = $connect->prepare("
                UPDATE " . DB_PREFIX . "produit
                SET nbVote = :nbVote
                WHERE idProduit = :produitId
            ");
            $queryPrepared->execute(['nbVote' => $newVoteCount, 'produitId' => $produitId]);

            // Supprimer le vote de l'utilisateur de la session
            unset($_SESSION['votes'][$produitId]);
        }
    }
}

// Rediriger vers la page précédente
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;