<?php session_start();
require('core/functions.php');
require('conf.inc.php');
include('template/head.php');
include('template/navbar.php');
?>
<?php
// Page commentaire avec formulaire d'ajout de commentaire. Le produit dont on est sur la page commentaires est résumé en haut de page
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

<!-- Récupération en base de données et affichage des commentaires et leur auteur -->

<?php $query = "SELECT c.id, c.commentaire, c.censure, u.nom, u.prenom FROM " . DB_PREFIX . "commentaires c INNER JOIN " . DB_PREFIX . "utilisateur u ON c.fk_id_utilisateur = u.id WHERE c.fk_id_produit = :produitId ORDER BY c.id DESC";
$queryPrepared = $connect->prepare($query);
$queryPrepared->execute(['produitId' => $produitId]);
$comments = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);

foreach ($comments as $comment):
    if ($comment['censure'] == 0) { ?>
        <div class="commentaires">
            <p>
                <?php echo $comment['commentaire']; ?>
            <form method="post" action="signaler.php">
                <input type="hidden" name="commentaire" value="<?php echo $comment['commentaire']; ?>">
                <input type="hidden" name="idCommentaire" value="<?php echo $comment['id']; ?>">
                <!-- Bouton pour signaler le commentaire -->
                <button type="submit">Signaler</button>
            </form>
            </p>
            <p>Par
                <?php echo $comment['nom'] . ' ' . $comment['prenom']; ?>

            </p>
        </div>
        <?php
    }
endforeach; ?>
<form action="add_comment.php" method="post">
    <input type="hidden" name="produitId" value="<?php echo $produitId; ?>">
    <textarea class="commentField" name="commentaire" placeholder="Laissez un commentaire..."></textarea>
    <button type="submit">Envoyer</button>
</form>