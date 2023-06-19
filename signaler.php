<?php session_start();
require('core/functions.php');
require('conf.inc.php');

$connect = connectDB();

$commentaireId = $_POST['idCommentaire'];
$signaleurId = $_SESSION['user_id'];


$sql = "INSERT INTO " . DB_PREFIX . "signalements (fk_id_commentaire, signaleur, traitee) VALUES (:commentaireId, :signaleurId, 0)";
$stmt = $connect->prepare($sql);
$stmt->bindParam(':commentaireId', $commentaireId);
$stmt->bindParam(':signaleurId', $signaleurId);
$stmt->execute();


header('Location: boutique.php');
exit;
?>