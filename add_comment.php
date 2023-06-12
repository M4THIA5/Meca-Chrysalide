<?php
session_start();
require_once('core/functions.php');
require_once('conf.inc.php');
redirectIfNotConnected();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $connect = connectDB();
    $produitId = $_POST['produitId'];
    $commentaire = $_POST['commentaire'];

    // REQUETE A CHANGER
    $query = "INSERT INTO " . DB_PREFIX . "commentaire (produit_id, commentaire) VALUES (:produitId, :commentaire)";
    $queryPrepared = $connect->prepare($query);
    $queryPrepared->execute(['produitId' => $produitId, 'commentaire' => $commentaire]);

}

// Rediriger vers la page précédente
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
?>