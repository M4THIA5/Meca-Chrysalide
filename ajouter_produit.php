<?php
session_start();
require_once('core/functions.php');
require_once('conf.inc.php');
redirectIfNotConnected();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $connect = connectDB();

    // Collecter les données du formulaire
    $idProduit = $_POST['idProduit'];
    $nomProduit = $_POST['nomProduit'];
    $descriptionProduit = $_POST['descriptionProduit'];
    $prixProduit = $_POST['prixProduit'];

    // Vérifier si un fichier a été téléchargé
    if (isset($_FILES['imageProduit']) && $_FILES['imageProduit']['error'] === 0) {
        // Déplacer le fichier vers un répertoire sur le serveur
        $targetDir = 'assets/img/';
        $targetFile = $targetDir . basename($_FILES['imageProduit']['name']);
        if (move_uploaded_file($_FILES['imageProduit']['tmp_name'], $targetFile)) {
            // Code à exécuter si le déplacement du fichier réussit
            // Insérer les données du produit dans la base de données
            $queryPrepared = $connect->prepare("
                INSERT INTO " . DB_PREFIX . "produit (idProduit, nomProduit, description, prix, image, vendu, nbVote)
                VALUES (:idProduit, :nomProduit, :descriptionProduit, :prixProduit, :imageProduit, 0, 0)
            ");
            $queryPrepared->execute([
                'idProduit' => $idProduit,
                'nomProduit' => $nomProduit,
                'descriptionProduit' => $descriptionProduit,
                'prixProduit' => $prixProduit,
                'imageProduit' => $targetFile
            ]);

            echo "Le produit a été ajouté avec succès.";
            header('Location: backoffice/backoffice.php');
        } else {
            echo "Une erreur s'est produite lors du déplacement du fichier.";
        }
    } else {
        echo "Une erreur s'est produite lors du téléchargement du fichier.";
    }
}
?>