<?php
session_start();
require('core/functions.php');
require('conf.inc.php');
include('template/head.php');
include('template/navbar.php');
?>
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
                <a href="commentaires.php?produitId=<?php echo $produit["idProduit"]; ?>">Commentaires</a>
                <?php if ($produit['vendu'] == 0): ?>
                    <a href="facturation.php?id=<?php echo $produit['idProduit']; ?>">
                        <button type="button">Acheter</button>
                    </a>
                <?php else: ?>
                    <h4>Vendu</h4>
                <?php endif; ?>

                <?php
                $produitId = $produit['idProduit'];
                $hasVoted = false;

                if (isset($_SESSION['user_id'])) {
                    $idUser = $_SESSION['user_id'];

                    $queryPrepared = $connect->prepare("
                    SELECT id
                    FROM " . DB_PREFIX . "votes
                    WHERE fk_id_utilisateur = :idUser AND fk_id_produit = :produitId
                ");
                    $queryPrepared->execute(['idUser' => $idUser, 'produitId' => $produitId]);
                    $vote = $queryPrepared->fetch();
                    $hasVoted = $vote !== false;

                    // Afficher le bouton "J'aime" ou "Enlever mon vote" en fonction du résultat de la requête
                    if ($hasVoted) {
                        echo '<form action="remove_vote.php" method="post">
                            <input type="hidden" name="produitId" value="' . $produitId . '">
                            <button type="submit" name="removeVote" value="1">Enlever mon vote</button>
                        </form>';
                    } elseif (isset($_SESSION['user_id'])) {
                        echo '<form action="vote.php" method="post">
                            <input type="hidden" name="produitId" value="' . $produitId . '">
                            <button type="submit" name="vote" value="1">J\'aime</button>
                        </form>';
                    }
                }

                // Affichage du nombre de votes
                $nbVotes = $produit["nbVote"];
                echo '<p>' . $nbVotes . ' vote(s)</p>';
                ?>
            </figure>
        <?php endforeach; ?>
    </div>
</section>
<?php include('template/footer.php'); ?>