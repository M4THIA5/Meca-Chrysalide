<?php
session_start();
require('functions.php');
require('../conf.inc.php');
redirectIfNotConnected();

if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    $connect = connectDB();

    // Vérifiez si l'utilisateur existe dans la base de données
    $queryPrepared = $connect->prepare("SELECT id FROM " . DB_PREFIX . "utilisateur WHERE id = :userId");
    $queryPrepared->execute(['userId' => $userId]);
    $result = $queryPrepared->fetch(PDO::FETCH_ASSOC);

    if ($result) {

        $queryPrepared = $connect->prepare("SELECT droitAdmin FROM " . DB_PREFIX . "utilisateur WHERE id = :userId");
        $queryPrepared->execute(['userId' => $userId]);
        $user = $queryPrepared->fetch(PDO::FETCH_ASSOC);

        // Inversez la valeur du droitAdmin (0 devient 1, et vice versa)
        $newAdminStatus = $user['droitAdmin'] == 0 ? 1 : 0;

        $queryPrepared = $connect->prepare("UPDATE " . DB_PREFIX . "utilisateur SET droitAdmin = :adminStatus WHERE id = :userId");
        $queryPrepared->execute(['adminStatus' => $newAdminStatus, 'userId' => $userId]);


        header("Location: ../backoffice.php");
        exit();
    }
}

header("Location: ../backoffice.php");
exit();
?>