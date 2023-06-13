<?php session_start();
require('core/functions.php');
require('conf.inc.php');
include('template/head.php');
include('template/navbar.php');
?>
<?php
$produitId = $_GET['produitId'];
$connect = connectDB();
$query = "SELECT * FROM " . DB_PREFIX . "produit WHERE idProduit = :produitId";
$queryPrepared = $connect->prepare($query);
$queryPrepared->execute(['produitId' => $produitId]);
$produit = $queryPrepared->fetch(PDO::FETCH_ASSOC); ?>

<h1>Commentaires pour
    <?php echo $produit['description']; ?>
</h1>
<img src="<?php echo $produit['image']; ?>" alt="<?php echo $produit['description']; ?>">
<h4>Prix :
    <?php echo $produit['prix']; ?>
</h4>
<h4>Nombre de votes :
    <?php echo $produit['nbVote']; ?>
</h4>
<?php $query = "SELECT c.commentaire, u.nom, u.prenom FROM " . DB_PREFIX . "commentaires c INNER JOIN " . DB_PREFIX . "utilisateur u ON c.fk_id_utilisateur = u.id WHERE c.fk_id_produit = :produitId";
$queryPrepared = $connect->prepare($query);
$queryPrepared->execute(['produitId' => $produitId]);
$comments = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
foreach ($comments as $comment): ?>
    <div>
        <p>
            <?php echo $comment['commentaire']; ?>
        </p>
        <p>Par
            <?php echo $comment['nom'] . ' ' . $comment['prenom']; ?>
        </p>
    </div>
<?php endforeach; ?>
<form action="add_comment.php" method="post">
    <input type="hidden" name="produitId" value="<?php echo $produitId; ?>">
    <textarea name="commentaire" placeholder="Laissez un commentaire..." required></textarea>
    <button type="submit">Envoyer</button>
</form>