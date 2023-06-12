<?php
session_start();
require_once('core/functions.php');
require_once('conf.inc.php');
redirectIfNotConnected();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $connect = connectDB();
    $idProduit = $_POST['produitId'];

    // Vérifier si le produit existe
    $queryPrepared = $connect->prepare("
        SELECT idProduit, nbVote
        FROM " . DB_PREFIX . "produit
        WHERE idProduit = :idProduit
    ");
    $queryPrepared->execute(['idProduit' => $idProduit]);
    $produit = $queryPrepared->fetch();

    if ($produit) {
        // Vérifier si l'utilisateur a déjà voté pour ce produit
        $hasVoted = isset($_SESSION['votes'][$idProduit]);
        if (!$hasVoted) {
            // Mettre à jour le nombre de votes
            $newVoteCount = $produit['nbVote'] + 1;
            $queryPrepared = $connect->prepare("
                UPDATE " . DB_PREFIX . "produit
                SET nbVote = :nbVote
                WHERE idProduit = :idProduit
            ");
            $queryPrepared->execute(['nbVote' => $newVoteCount, 'idProduit' => $idProduit]);

            // Enregistrer le vote de l'utilisateur dans la session
            $_SESSION['votes'][$idProduit] = true;
        }
    }
}

// Rediriger vers la page précédente
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;