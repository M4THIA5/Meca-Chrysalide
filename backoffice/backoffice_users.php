<?php
session_start();
require_once('../core/functions.php');
require_once('../conf.inc.php');
include_once('../template/head.php');
include_once('../template/navbar.php');
redirectIfNotConnected();
?>
<section class="backoffice-users">
    <h2>Utilisateurs</h2>
    <div class="search-container">
        <input type="text" id="search-input" placeholder="Rechercher par nom, prenom ou e-mail">
        <button id="search-button" onclick="searchUsers()">Rechercher</button>
    </div>

    <table class="panneauUtilisateurs">
        <thead>
            <tr>
                <th>Id</th>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Date de naissance</th>
                <th>Date d'insertion</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="search-results">

        </tbody>
    </table>
</section>
<?php include_once('../template/footer.php'); ?>
<script src="../js/search.js"></script>