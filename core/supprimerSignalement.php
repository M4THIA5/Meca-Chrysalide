<?php
session_start();
require('functions.php');
require('../conf.inc.php');
// Vérifier si l'administrateur est connecté et a les autorisations nécessaires

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer l'identifiant du signalement à supprimer depuis le formulaire
    $signalementId = $_POST['signalement_id'];
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Récupérer l'identifiant du signalement à supprimer depuis l'URL
    $signalementId = $_GET['id'];
}
$connect = connectDB();


// Mettre à jour la colonne "traitee" dans la table des signalements
$queryTraiterSignalement = "UPDATE " . DB_PREFIX . "signalements SET traitee = 1 WHERE id = :signalement_id";
$stmtTraiterSignalement = $connect->prepare($queryTraiterSignalement);
$stmtTraiterSignalement->bindParam(':signalement_id', $signalementId, PDO::PARAM_INT);
$stmtTraiterSignalement->execute();

// Récupérer l'identifiant du commentaire associé au signalement
$queryGetCommentaireId = "SELECT fk_id_commentaire FROM " . DB_PREFIX . "signalements WHERE id = :signalement_id";
$stmtGetCommentaireId = $connect->prepare($queryGetCommentaireId);
$stmtGetCommentaireId->bindParam(':signalement_id', $signalementId, PDO::PARAM_INT);
$stmtGetCommentaireId->execute();

$commentaireId = $stmtGetCommentaireId->fetchColumn();

$queryMarquerCensure = "UPDATE " . DB_PREFIX . "commentaires SET censure = 1 WHERE id = :commentaire_id";
$stmtMarquerCensure = $connect->prepare($queryMarquerCensure);
$stmtMarquerCensure->bindParam(':commentaire_id', $commentaireId, PDO::PARAM_INT);
$stmtMarquerCensure->execute();


// Rediriger vers la page de gestion des signalements
header("Location: ../signalements.php");
exit();


?>