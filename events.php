<?php session_start();
require('core/functions.php');
require('conf.inc.php');
include('template/head.php');
include('template/navbar.php'); 
redirectIfNotConnected();
?>

<h1> Evènements </h1>

<h3> Retrouvez Meca-Chrysalide dans les galeries suivantes : </h2>

    <div class="events">
        <p> <a href="https://www.galerie-artisanart.com/"> Galerie Artisan'Art </a> </p>
        <p> Retrouvez les oeuvres de meca chrysalide du 12 juin au 25 août 2023 a la galerie Aretisan'Art d'Orleans !
        </p>


        <?php include('template/footer.php'); ?>