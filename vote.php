<?php
session_start();
require_once('core/functions.php');
require_once('conf.inc.php');
redirectIfNotConnected();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $connect = connectDB();
    $produitId = $_POST['produitId'];
    $idUser = $_SESSION['user_id'];

    // Vérifier si l'utilisateur a déjà voté pour ce produit
    $queryPrepared = $connect->prepare("
        SELECT id
        FROM " . DB_PREFIX . "votes
        WHERE fk_id_utilisateur = :idUser AND fk_id_produit = :produitId
    ");
    $queryPrepared->execute(['idUser' => $idUser, 'produitId' => $produitId]);
    $vote = $queryPrepared->fetch();

    if (!$vote) {
        // Insérer un nouveau vote dans la table "votes"
        $queryPrepared = $connect->prepare("
            INSERT INTO " . DB_PREFIX . "votes (fk_id_utilisateur, fk_id_produit)
            VALUES (:idUser, :produitId)
        ");
        $queryPrepared->execute(['idUser' => $idUser, 'produitId' => $produitId]);

        // Mettre à jour le nombre de votes dans la table "produit"
        $queryPrepared = $connect->prepare("
            UPDATE " . DB_PREFIX . "produit
            SET nbVote = nbVote + 1
            WHERE idProduit = :produitId
        ");
        $queryPrepared->execute(['produitId' => $produitId]);

        // Ajouter le vote de l'utilisateur à la session
        $_SESSION['votes'][$produitId] = true;
    }
}

// Rediriger vers la page précédente
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;