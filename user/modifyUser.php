<?php
session_start();
require('../core/functions.php');
require('../conf.inc.php');
redirectIfNotConnected();

$connect = connectDB();

// Récupérer l'ID de l'utilisateur connecté depuis la variable de session
$userId = $_SESSION['user_id'];

// Récupérer les données du formulaire
$lastname = $_POST['lastname'];
$firstname = $_POST['firstname'];
$email = $_POST['email'];
$anniversaire = $_POST['anniversaire'];
$telephone = $_POST['telephone'];
$pwdActuel = $_POST['pwdActuel'];
$nouveauPwd = $_POST['nouveauPwd'];
$confirmPwd = $_POST['confirmPwd'];

// Vérifier si au moins l'un des champs de mise à jour est rempli
if (empty($lastname) && empty($firstname) && empty($email) && empty($anniversaire) && empty($telephone) && empty($pwdActuel) && empty($nouveauPwd) && empty($confirmPwd)) {
    echo "Aucune modification n'a été effectuée.";
    exit();
}

// Construire la requête SQL en fonction des champs remplis
$sql = "UPDATE " . DB_PREFIX . "utilisateur SET ";
$params = array();

if (!empty($lastname)) {
    $sql .= "nom = :lastname, ";
    $params['lastname'] = $lastname;
}

if (!empty($firstname)) {
    $sql .= "prenom = :firstname, ";
    $params['firstname'] = $firstname;
}

if (!empty($email)) {
    $sql .= "email = :email, ";
    $params['email'] = $email;
}

if (!empty($anniversaire)) {
    $sql .= "anniversaire = :anniversaire, ";
    $params['anniversaire'] = $anniversaire;
}

if (!empty($telephone)) {
    $sql .= "telephone = :telephone, ";
    $params['telephone'] = $telephone;
}

// Vérifier si les champs de mot de passe sont remplis et valides
if (!empty($pwdActuel) && !empty($nouveauPwd) && !empty($confirmPwd) && $nouveauPwd === $confirmPwd) {
    // Champs de mot de passe valides, les ajouter à la requête SQL
    $sql .= "mdp = :pmdp, ";
    $params['pmdp'] = password_hash($nouveauPwd, PASSWORD_DEFAULT);
}

// Supprimer la virgule et l'espace finales de la requête SQL
$sql = rtrim($sql, ', ');

// Ajouter la clause WHERE pour la condition de mise à jour
$sql .= " WHERE id = :userId"; // Utiliser l'ID de l'utilisateur connecté

// Exécuter la requête SQL
$queryPrepared = $connect->prepare($sql);
$queryPrepared->bindParam(':userId', $userId, PDO::PARAM_INT);
$queryPrepared->execute(array_merge($params, ['userId' => $userId]));


// Rediriger vers la page de profil ou afficher un message de succès
if ($queryPrepared->rowCount() > 0) {
    // Mise à jour réussie
    header("Location: profil.php");
    exit();
} else {
    // Aucune mise à jour effectuée
    echo "Aucune modification n'a été effectuée.";
}
?>