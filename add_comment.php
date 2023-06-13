<?php session_start();
require_once('core/functions.php');
require_once('conf.inc.php');

$produitId = $_POST['produitId'];
$commentaire = $_POST['commentaire'];
$utilisateurId = $_SESSION['user_id'];

$connect = connectDB();
$query = "INSERT INTO " . DB_PREFIX . "commentaires (fk_id_produit, fk_id_utilisateur, commentaire) VALUES (:produitId, :utilisateurId, :commentaire)";
$queryPrepared = $connect->prepare($query);
$queryPrepared->execute(['produitId' => $produitId, 'utilisateurId' => $utilisateurId, 'commentaire' => $commentaire]);
header("Location: commentaires.php?produitId=" . $produitId);
exit();