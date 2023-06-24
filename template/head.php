<!DOCTYPE html>
<html lang="FR-fr">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Meca Chrysalide">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meca-Chrysalide par Félix Boyer</title>
    <link href="/MecaChrysalide/style/Style.css" rel="stylesheet">



</head>

<body>
    <?php
    if (isConnected()) {
        // Se connecter à la base de données
        $connect = connectDB();

        // Récupérer l'identifiant de l'utilisateur connecté (vous devez avoir cette information dans votre système d'authentification)
        $userId = $_SESSION['user_id'];

        // Récupérer le nom de la page actuelle
        $page = $_SERVER['PHP_SELF'];

        // Insérer le log de connexion dans la table des logs
        $queryInsertLog = "INSERT INTO " . DB_PREFIX . "logsUser (fk_id_utilisateur, heure_connexion, page) VALUES (:user_id, NOW(), :page)";
        $stmtInsertLog = $connect->prepare($queryInsertLog);
        $stmtInsertLog->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmtInsertLog->bindParam(':page', $page, PDO::PARAM_STR);
        $stmtInsertLog->execute();
    }
    ?>