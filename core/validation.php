<?php
session_start();
require "../conf.inc.php";
require "functions.php";

// Vérifier si le code de validation est présent dans l'URL
if (isset($_GET['code'])) {
    $codeValidation = $_GET['code'];

    // Rechercher l'utilisateur correspondant au code de validation dans la base de données
    $connection = connectDB();
    $queryPrepared = $connection->prepare("SELECT id FROM " . DB_PREFIX . "utilisateur WHERE code_validation=:code");
    $queryPrepared->execute([
        "code" => $codeValidation
    ]);

    $result = $queryPrepared->fetch();

    if (!empty($result)) {
        // Mettre à jour le statut de validation de l'utilisateur dans la base de données
        $queryPrepared = $connection->prepare("UPDATE " . DB_PREFIX . "utilisateur SET est_valide=1, code_validation=NULL WHERE id=:id");
        $queryPrepared->execute([
            "id" => $result['id']
        ]);

        // Redirection vers la page de succès de la validation
        header("location: /login.php");
        exit();
    }
}

// Si le code de validation est incorrect ou non présent, afficher un message d'erreur
$_SESSION['error_message'] = "Le lien de validation est invalide. Veuillez vérifier votre e-mail ou contacter l'assistance.";
header("location: register.php");
exit();
?>