<?php
session_start();
include('../conf.inc.php');
include('../core/functions.php');
include('../template/head.php');
include('../template/navbar.php');
redirectIfNotConnected();
// Code pour se connecter à la base de données et récupérer les produits
$connect = connectDB();
$query = "SELECT * FROM " . DB_PREFIX . "produit";
$stmt = $connect->query($query);
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Afficher les produits avec les boutons de suppression et de disponibilité
foreach ($produits as $produit) {
    echo "<figure class='adminboutique'>
     <h4>" . $produit['nomProduit'] . "</h4>
     <img src='../" . $produit['image'] . "' alt='" . $produit['description'] . "'>
     <p>" . $produit['description'] . "</p>";
    if ($produit['obsolete'] == 1) {
        echo "<form method='post' action='../retablirProduit.php'>
        <input type='hidden' name='produit_id' value='" . $produit['idProduit'] . "'>
        <button type='submit'>rétablir le produit</button>
        </form>";
    } else {


        echo " <form method='post' action='../supprimer_produit.php'>
     <input type='hidden' name='produit_id' value='" . $produit['idProduit'] . "'>
     <button type='submit'>Supprimer</button>
     </form>


    <form method='post' action='marquer_vendu.php'>
    <input type='hidden' name='produit_id' value='" . $produit['idProduit'] . "'>
    <button type='submit'>Marquer comme vendu</button>
     </form>";

    }
    echo "</figure>";
}
include('../template/footer.php');
?>