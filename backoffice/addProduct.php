<?php session_start();
require('../core/functions.php');
require('../conf.inc.php');
include('../template/head.php');
include('../template/navbar.php');
?>
<?php redirectIfNotConnected(); ?>
<h1> Ajouter un produit à la boutique </h1>
<div class="formAddProduct">
    <form action="../ajouter_produit.php" method="post" enctype="multipart/form-data">
        <label for="idProduit">ID :</label>
        <input type="text" name="idProduit" required><br>

        <label for="nomProduit">Nom :</label>
        <input type="text" name="nomProduit" required><br>

        <label for="descriptionProduit">Description :</label>
        <input type="text" name="descriptionProduit" required></input><br>

        <label for="prixProduit">Prix :</label>
        <input type="number" name="prixProduit" step="0.01" required><br>

        <label for="imageProduit">Image :</label>
        <input type="file" id="imageProduit" name="imageProduit" onchange="checkImageSize(this)">
        <br>

        <input type="submit" value="Ajouter le produit">
    </form>
</div>

<!-- Script JS qui vérifie la taille de l'image avant d'envoyer le formulaire, pas pertinent de faire un autre fichier -->
<script>
    function checkImageSize(input) {
        if (input.files && input.files[0]) {
            var file = input.files[0];
            var img = new Image();

            img.onload = function () {
                if (img.width > 300 || img.height > 300) {
                    alert("La taille de l'image dépasse la limite de 300x300 pixels. Veuillez choisir une autre image.");
                    input.value = ""; // Réinitialiser la valeur du champ de téléchargement
                }
            };

            img.src = URL.createObjectURL(file);
        }
    }
</script>