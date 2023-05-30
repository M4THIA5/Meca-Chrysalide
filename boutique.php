<?php session_start(); ?>
<?php require('core/functions.php'); ?>
<?php require('conf.inc.php'); ?>
<?php include('template/head.php'); ?>
<?php include('template/navbar.php'); ?>

<h1> Boutique </h1>

<h3> Ici, vous pouvez acquérir une des oeuvres disponibles et ainsi soutenir l'artiste ! </h2>

    <section>
        <h4> Oeuvres disponibles </h4>
        <div class="boutique">
            <?php

            $connect = connectDB();
            $queryPrepared = $connect->query("SELECT * FROM " . DB_PREFIX . "produit");
            $produits = $queryPrepared->fetchAll();

            foreach ($produits as $produit) {
                echo '<figure> <img alt="' . $produit["description"] . '" src="' . $produit["image"] . '">
                <figcaption> ' . $produit["description"] . ' </figcaption>
                <h4> Prix : ' . $produit["prix"] . ' </h4>';
                if ($produit["vendu"] == 0) {
                    echo '
                    <a href="facturation.php?id=' . $produit["idProduit"] . '"><button type="button">Acheter</button></a>';
                }
                echo '</a></figure>';
            }
            ?>
        </div>
    </section>

    <?php include('template/footer.php'); ?>