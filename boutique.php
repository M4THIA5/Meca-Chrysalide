<?php
session_start();
require('core/functions.php');
require('conf.inc.php');
include('template/head.php');
include('template/navbar.php');
?>
<script src="comment.js"></script>
<?php

$connect = connectDB();
$queryPrepared = $connect->query("SELECT * FROM " . DB_PREFIX . "produit");
$produits = $queryPrepared->fetchAll();

?>

<h1> Boutique </h1>

<h3> Ici, vous pouvez acquérir une des œuvres disponibles et ainsi soutenir l'artiste ! </h3>

<section>
    <h4> Œuvres disponibles </h4>
    <div class="boutique">
        <?php foreach ($produits as $produit): ?>
            <figure>
                <img alt="<?php echo $produit['description']; ?>" src="<?php echo $produit['image']; ?>">
                <figcaption>
                    <?php echo $produit['description']; ?>
                </figcaption>
                <h4>Prix :
                    <?php echo $produit['prix']; ?>
                </h4>
                <a href="#" class="comment-button" data-produitid=" <?php echo $produit["idProduit"]; ?>">Commentaires</a>
                <?php if ($produit['vendu'] == 0): ?>
                    <a href="facturation.php?id=<?php echo $produit['idProduit']; ?>">
                        <button type="button">Acheter</button>
                    </a>
                <?php else: ?>
                    <h4>Vendu</h4>
                <?php endif; ?>

                <?php
                $produitId = $produit['idProduit'];
                $hasVoted = isset($_SESSION['votes'][$produitId]);

                // Afficher le bouton "J'aime" uniquement si l'utilisateur n'a pas encore voté pour ce produit
                if (!$hasVoted) {
                    echo '<form action="vote.php" method="post">
                            <input type="hidden" name="produitId" value="' . $produitId . '">
                            <button type="submit" name="vote" value="1">J\'aime</button>
                          </form>';
                } else {
                    echo '<form action="remove_vote.php" method="post">
                            <input type="hidden" name="produitId" value="' . $produitId . '">
                            <button type="submit" name="removeVote" value="1">Enlever mon vote</button>
                          </form>';
                }

                // Affichage du nombre de votes
                $nbVotes = $produit["nbVote"];
                echo '<p>' . $nbVotes . ' vote(s)</p>';
                ?>
            </figure>
        <?php endforeach; ?>
    </div>
</section>
<script src="comment.js"></script>
<?php include('template/footer.php'); ?>