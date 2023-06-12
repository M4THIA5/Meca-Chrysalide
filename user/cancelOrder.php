<?php
session_start();
require_once('../core/functions.php');
require_once('../conf.inc.php');
redirectIfNotConnected();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $connect = connectDB();
    $idCommande = $_POST['idCommande'];

    // Vérifier si la commande appartient à l'utilisateur connecté
    $queryPrepared = $connect->prepare("
        SELECT fkIdUtilisateur
        FROM " . DB_PREFIX . "commande
        WHERE idCommande = :idCommande
    ");
    $queryPrepared->execute(['idCommande' => $idCommande]);
    $result = $queryPrepared->fetch();

    if ($result && $result['fkIdUtilisateur'] === $_SESSION['user_id']) {
        $queryPrepared = $connect->prepare("
            DELETE FROM " . DB_PREFIX . "commande
            WHERE idCommande = :idCommande
        ");
        $queryPrepared->execute(['idCommande' => $idCommande]);

        $_SESSION['success_message'] = "La commande a été annulée avec succès.";
        header("Location: profil.php");
        exit;
    }
}

header("Location: profil.php");
exit;
?>