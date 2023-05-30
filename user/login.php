<?php session_start(); ?>
<?php require('../core/functions.php'); ?>
<?php require('../conf.inc.php'); ?>
<?php include('../template/head.php'); ?>
<?php include('../template/navbar.php'); ?>

<h1> Se connecter </h1>

<?php

if (!empty($_POST["email"]) && !empty($_POST["pwd"])) {

    $email = cleanEmail($_POST["email"]);
    $pwd = $_POST['pwd'];

    $connect = connectDB();
    $queryPrepared = $connect->prepare("SELECT id, mdp FROM " . DB_PREFIX . "utilisateur WHERE email=:email");
    $queryPrepared->execute(["email" => $email]);
    $result = $queryPrepared->fetch();

    if (empty($result)) {
        echo "Identifiants incorrects";
    } else if (password_verify($pwd, $result["mdp"])) {
        $_SESSION['email'] = $email;
        $_SESSION['login'] = 1;
        $_SESSION['id'] = $result["id"];
        header("Location: ../index.php");
    } else {
        echo "Identifiants incorrects";
    }
}
?>

<form method="POST">
    <input type="email" name="email" placeholder="Votre email" required="required">
    <input type="password" name="pwd" id="pwd" placeholder="Votre mot de passe" required="required">
    <button>Se connecter</button>
</form>

<?php include('../template/footer.php'); ?>