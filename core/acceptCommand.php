<?php session_start();
require('functions.php');
require('../conf.inc.php');

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si l'ID de commande est présent dans la requête
    if (isset($_POST['idCommande'])) {
        $idCommande = $_POST['idCommande'];

        // Connectez-vous à la base de données
        $connect = connectDB();

        // Commencer une transaction
        $connect->beginTransaction();

        try {
            // Mettre à jour le champ est_acceptee de l'offre acceptée en 1 (acceptée)
            $queryPrepared = $connect->prepare("UPDATE " . DB_PREFIX . "commande SET est_acceptee = 1 WHERE idCommande = :idCommande");
            $queryPrepared->execute([
                'idCommande' => $idCommande
            ]);

            // Récupérer le produit de l'offre acceptée
            $queryPrepared = $connect->prepare("SELECT fkIdProduit FROM " . DB_PREFIX . "commande WHERE idCommande = :idCommande");
            $queryPrepared->execute([
                'idCommande' => $idCommande
            ]);
            $result = $queryPrepared->fetch(PDO::FETCH_ASSOC);

            $fkIdProduit = $result['fkIdProduit'];

            // Mettre à jour les autres offres du même produit en les marquant comme refusées (-1)
            $queryPrepared = $connect->prepare("UPDATE " . DB_PREFIX . "commande SET est_acceptee = -1 WHERE fkIdProduit = :fkIdProduit AND est_acceptee = 0 AND idCommande != :idCommande");
            $queryPrepared->execute([
                'fkIdProduit' => $fkIdProduit,
                'idCommande' => $idCommande
            ]);

            // Valider la transaction
            $connect->commit();

            // Rediriger vers la page des commandes avec un message de succès
            header("Location: ../backoffice_commandes.php");
            exit;
        } catch (Exception $e) {
            // En cas d'erreur, annuler la transaction
            $connect->rollBack();
            // Rediriger vers une page d'erreur ou de retour
            header("Location: ../index.php");
            exit;
        }
    }
}

// Si le formulaire n'a pas été soumis correctement, rediriger vers une page d'erreur ou de retour
header("Location: ../index.php");
exit;
?>