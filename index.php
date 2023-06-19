<?php session_start(); ?>
<?php require('conf.inc.php'); ?>
<?php require('core/functions.php'); ?>
<?php include('template/head.php'); ?>
<?php include('template/navbar.php'); ?>

<main>
    <header class="baniere">

        <h1><a href="index.php"> Meca-Chrysalide</a></h1>
        <h2> Par</h2>
        <h2><a href="apropos.php"> Félix Boyer</a></h2>

        <section>
            <p class="presentation">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestiae consectetur culpa magni quod
                voluptates
                impedit commodi harum reiciendis et fugiat! Expedita temporibus repellendus accusamus modi facere fuga
                id
                eligendi at.
            </p>

        </section>
    </header>
    <?php
    // Liste des oeuvres les plus populaires (les 3 premiers qui ont le plus de votes sont affichés)
    $query = "SELECT p.idProduit, p.nomProduit, p.image, p.nbVote AS total_votes
          FROM " . DB_PREFIX . "produit p
          ORDER BY total_votes DESC
          LIMIT 3";
    $connect = connectDB();
    $stmt = $connect->query($query);
    $oeuvresPopulaires = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <section class="topoeuvres">
        <h3> Oeuvres les plus populaires </h3>
        <header>
            <h4>Les oeuvres qui ont reçu le plus de votes ces derniers mois :</h4>
        </header>
        <div class="oeuvrespop">
            <?php foreach ($oeuvresPopulaires as $oeuvre): ?>
                <figure>
                    <a href="assets/img/<?php echo $oeuvre['image']; ?>" target="_blank">
                        <img alt="une des oeuvres les plus populaires !" src="<?php echo $oeuvre['image']; ?>">
                        <figcaption>
                            <?php echo $oeuvre['nomProduit']; ?><br>
                            Nombre de votes :
                            <?php echo $oeuvre['total_votes'] ?>
                        </figcaption>
                    </a>
                </figure>
            <?php endforeach; ?>
        </div>
    </section>




    <?php
    // Listes aléatoire des produits disponible en boutique (3 produits)
    $query = "SELECT idProduit, nomProduit, image
          FROM " . DB_PREFIX . "produit
          WHERE vendu = 0
          ORDER BY RAND()
          LIMIT 3";
    $connect = connectDB();
    $stmt = $connect->query($query);
    $apercuBoutique = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <section>
        <h3> Aperçu de la boutique </h3>
        <header>
            <h4> Quelques œuvres disponibles à la boutique :</h4>
        </header>
        <div class="shopview">
            <?php foreach ($apercuBoutique as $produit): ?>
                <figure>
                    <a href="assets/img/<?php echo $produit['image']; ?>" target="_blank">
                        <img alt="une des œuvres les plus populaires !" src="<?php echo $produit['image']; ?>">
                        <figcaption>
                            <?php echo $produit['nomProduit']; ?>
                        </figcaption>
                    </a>
                </figure>
            <?php endforeach; ?>
        </div>
    </section>

</main>

<?php include('template/footer.php'); ?>