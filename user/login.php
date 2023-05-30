<?php session_start();
require('../core/functions.php');
require('../conf.inc.php');
include('../template/head.php');
include('../template/navbar.php'); 
redirectIfConnected()
?>

<h1> Se connecter </h1>

<?php

if( !empty($_POST["email"]) &&  !empty($_POST["pwd"])) {

    $email = cleanEmail($_POST["email"]);
    $pwd = $_POST['pwd'];

    $connect = connectDB();
    $queryPrepared = $connect->prepare("SELECT mdp FROM ".DB_PREFIX."utilisateur WHERE email=:email");
    $queryPrepared->execute(["email"=>$email]);
    $result = $queryPrepared->fetch();

    if(empty($result)){
        echo "Indentifiants incorrects";
    }else if(password_verify($pwd, $result["mdp"])){
        $_SESSION['email'] =$email;
        $_SESSION['login'] =1;
        header("Location: ../index.php");
    }else{
        echo "Indentifiants incorrects";
    }
}
?>

<form method="POST">
	<input type="email" name="email" placeholder="Votre email" required="required">
	<input type="password" name="pwd" id="pwd" placeholder="Votre mot de passe" required="required">
	<button>Se connecter</button>
</form>

<?php include('../template/footer.php'); ?>