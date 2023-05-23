<?php 
session_start();
require('../core/functions.php');
require('../conf.inc.php');
include('../template/head.php');
include('../template/navbar.php');
redirectIfNotConnected();
?>

<h1> MON PROFILE </h1>

<?php include('../template/footer.php'); ?>