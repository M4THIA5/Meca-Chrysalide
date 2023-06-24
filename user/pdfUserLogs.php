<?php
session_start();
require('../conf.inc.php');
require('../core/functions.php');
require('../template/TCPDF-main/tcpdf.php');

// Récupérer l'identifiant de l'utilisateur connecté (vous devez avoir cette information dans votre système d'authentification)
$userId = $_SESSION['user_id'];

// Se connecter à la base de données
$connect = connectDB();

// Récupérer les informations de l'utilisateur depuis la table "utilisateur"
$queryUser = "SELECT nom, prenom, email, anniversaire, telephone, dateInscription FROM " . DB_PREFIX . "utilisateur WHERE id = :user_id";
$stmtUser = $connect->prepare($queryUser);
$stmtUser->bindParam(':user_id', $userId, PDO::PARAM_INT);
$stmtUser->execute();
$userData = $stmtUser->fetch(PDO::FETCH_ASSOC);

// Récupérer les commandes de l'utilisateur depuis la table "commandes" avec les coordonnées associées depuis la table "coordonnees"
$queryCommandes = "SELECT c.idCommande, c.dateCommande, co.nomDestinataire, co.prenomDestinataire, co.rue, co.ville, co.codePostal, co.telephone, co.email 
                  FROM " . DB_PREFIX . "commande c 
                  INNER JOIN " . DB_PREFIX . "coordonnees co ON c.fkIdCoordonnees = co.idCo 
                  WHERE c.fkIdUtilisateur = :user_id";

$stmtCommandes = $connect->prepare($queryCommandes);
$stmtCommandes->bindParam(':user_id', $userId, PDO::PARAM_INT);
$stmtCommandes->execute();
$commandes = $stmtCommandes->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les commentaires de l'utilisateur depuis la table "commentaires"
$queryCommentaires = "SELECT com.id, com.commentaire, prod.nomProduit AS nomProduit 
                     FROM " . DB_PREFIX . "commentaires com 
                     INNER JOIN " . DB_PREFIX . "produit prod ON com.fk_id_produit = prod.idProduit 
                     WHERE com.fk_id_utilisateur = :user_id";

$stmtCommentaires = $connect->prepare($queryCommentaires);
$stmtCommentaires->bindParam(':user_id', $userId, PDO::PARAM_INT);
$stmtCommentaires->execute();
$commentaires = $stmtCommentaires->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les signalements de l'utilisateur depuis la table "signalements"
$querySignalements = "SELECT c.commentaire AS commentaire_signale, u.nom, u.prenom 
                     FROM " . DB_PREFIX . "signalements s 
                     INNER JOIN " . DB_PREFIX . "commentaires c ON s.fk_id_commentaire = c.id 
                     INNER JOIN " . DB_PREFIX . "utilisateur u ON c.fk_id_utilisateur = u.id 
                     WHERE s.Signaleur = :user_id";



$stmtSignalements = $connect->prepare($querySignalements);
$stmtSignalements->bindParam(':user_id', $userId, PDO::PARAM_INT);
$stmtSignalements->execute();
$signalements = $stmtSignalements->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les votes de l'utilisateur depuis la table "votes" avec les informations sur les œuvres depuis la table "produit"
$queryVotes = "SELECT p.nomProduit
               FROM " . DB_PREFIX . "votes v 
               INNER JOIN " . DB_PREFIX . "produit p ON v.fk_id_produit = p.idProduit 
               WHERE v.fk_id_utilisateur = :user_id";


$stmtVotes = $connect->prepare($queryVotes);
$stmtVotes->bindParam(':user_id', $userId, PDO::PARAM_INT);
$stmtVotes->execute();
$votes = $stmtVotes->fetchAll(PDO::FETCH_ASSOC);

// Recupération des logs de l'utilisateur depuis la table "logsUser"
$queryLogsUser = "SELECT heure_connexion, page FROM " . DB_PREFIX . "logsUser WHERE fk_id_utilisateur = :user_id";

$stmtLogsUser = $connect->prepare($queryLogsUser);
$stmtLogsUser->bindParam(':user_id', $userId, PDO::PARAM_INT);
$stmtLogsUser->execute();
$logsUserData = $stmtLogsUser->fetchAll(PDO::FETCH_ASSOC);

// Instancier un nouvel objet TCPDF
$pdf = new TCPDF();

// Ajouter une page au document PDF
$pdf->AddPage();

// Ajouter les informations de l'utilisateur au contenu du PDF
$pdf->Write(10, "Informations de l'utilisateur : ");
$pdf->Write(10, "Nom : " . $userData['nom']);
$pdf->Write(10, "Prénom : " . $userData['prenom']);
$pdf->Write(10, "Email : " . $userData['email']);
$pdf->Write(10, "Date de naissance : " . $userData['anniversaire']);
$pdf->Write(10, "Numéro de téléphone : " . $userData['telephone']);
$pdf->Write(10, "Date d'inscription : " . $userData['dateInscription']);
$pdf->Write(10, "\n");

// Ajouter les commandes de l'utilisateur au contenu du PDF
$pdf->Write(10, "Commandes : ");
foreach ($commandes as $commande) {
    $pdf->Write(10, "Numéro de commande : " . $commande['idCommande']);
    $pdf->Write(10, "Date de commande : " . $commande['dateCommande']);
    $pdf->Write(10, "Nom du destinataire : " . $commande['nomDestinataire']);
    $pdf->Write(10, "Prénom du destinataire : " . $commande['prenomDestinataire']);
    $pdf->Write(10, "Rue : " . $commande['rue']);
    $pdf->Write(10, "Ville : " . $commande['ville']);
    $pdf->Write(10, "Code postal : " . $commande['codePostal']);
    $pdf->Write(10, "Téléphone : " . $commande['telephone']);
    $pdf->Write(10, "Email : " . $commande['email']);
    $pdf->Write(10, "\n");
}

// Ajouter les commentaires de l'utilisateur au contenu du PDF
$pdf->Write(10, "Commentaires : ");
foreach ($commentaires as $commentaire) {
    $pdf->Write(10, "Commentaire : " . $commentaire['commentaire']);
    $pdf->Write(10, "Nom du produit : " . $commentaire['nomProduit']);
    $pdf->Ln();
    $pdf->Write(10, "\n");
}

// Ajouter les signalements de l'utilisateur au contenu du PDF
$pdf->Write(10, "Signalements : ");
foreach ($signalements as $signalement) {
    $pdf->Write(10, "Commentaire signalé : " . $signalement['commentaire_signale']);
    $pdf->Write(10, "Auteur du commentaire : " . $signalement['prenom'] . " " . $signalement['nom']);
    $pdf->Write(10, "\n");
}

// Ajouter les votes de l'utilisateur au contenu du PDF
$pdf->Write(10, "Votes : ");
foreach ($votes as $vote) {
    $pdf->Write(10, "Nom de l'oeuvre : " . $vote['nomProduit']);
    $pdf->Write(10, "\n");
}

// Ajouter les logs de l'utilisateur au contenu du PDF
$pdf->Write(10, "Logs :");
foreach ($logsUserData as $logsUser) {
    $pdf->Write(10, "Informations de connexion :");
    $pdf->Write(10, "Heure de connexion : " . $logsUser['heure_connexion']);
    $pdf->Write(10, "Page visitée : " . $logsUser['page']);
    $pdf->Write(10, "\n");
}

// Nom du fichier PDF à télécharger
$filename = 'informations_utilisateur.pdf';

// Rendre le contenu du PDF et le télécharger
$pdf->Output($filename, 'D');
header("Location: profil.php");
?>