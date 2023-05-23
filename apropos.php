<?php session_start();
require('core/functions.php');
require('conf.inc.php');
include('template/head.php');
include('template/navbar.php'); 
redirectIfNotConnected();
?>
<h1> A propos </h1>

C fefe qui va remplir <br>
Lorem ipsum, dolor sit amet consectetur adipisicing elit. Cum modi eius magnam, atque error impedit mollitia, alias
nesciunt a hic aperiam ea minus? Deleniti deserunt aliquam, placeat ratione eius dolores.
Lorem ipsum dolor sit amet consectetur.....

<?php include('template/footer.php'); ?>