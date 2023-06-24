<?php session_start();
require('../core/functions.php');
require('../conf.inc.php');
include('../template/head.php');
include('../template/navbar.php');
$connect = connectDB();

// Requête SQL pour obtenir la valeur maximale de l'ID dans la table "produits"
$query = "SELECT MAX(idProduit) AS max_id FROM " . DB_PREFIX . "produit";
$result = $connect->query($query);
$row = $result->fetch(PDO::FETCH_ASSOC);

// Calculer le prochain ID disponible en incrémentant la valeur maximale de 1
$nextID = $row['max_id'] + 1;

redirectIfNotConnected(); ?>
<h1> Ajouter un produit à la boutique </h1>
<div class="formAddProduct">
    <form action="../ajouter_produit.php" method="post" enctype="multipart/form-data">
        <label for="idProduit">ID :</label>
        <input type="text" name="id" id="id" value="<?php echo $nextID; ?>" readonly>

        <label for="nomProduit">Nom :</label>
        <input type="text" name="nomProduit" required><br>

        <label for="descriptionProduit">Description :</label>
        <input type="text" name="descriptionProduit" required></input><br>

        <label for="prixProduit">Prix :</label>
        <input type="number" name="prixProduit" step="0.01" required><br>

        <label for="imageProduit">Image : (300x300 px max)</label>
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
<?php include('../template/footer.php'); ?>