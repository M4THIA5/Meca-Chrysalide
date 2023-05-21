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
    <section class="topoeuvres">
        <h3> Oeuvres les plus populaires </h3>
        <header>
            <h4>Les oeuvres qui ont recu le plus de vote ces derniers mois : </h4>
        </header>
        <div class=" oeuvrespop">
            <figure><a href="assets/img/chat1.jpg" target="_blank"> <img alt="une des oeuvre les plus populaires !"
                        src="assets/img/chat1.jpg">
                    <figcaption> Un Chat </figcaption>
                </a>
                <div class="rating">
                    <span>☆</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span>
                </div>
            </figure>
            <figure> <a href="assets/img/chat2.jpg" target="_blank"> <img alt="une des oeuvre les plus populaires !"
                        src="assets/img/chat2.jpg">
                    <figcaption> Un autre Chat </figcaption>
                    <div class="rating">
                        <span>☆</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span>
                    </div>
            </figure>
            <figure> <a href="assets/img/chat3.jpg" target="_blank"> <img alt="une des oeuvre les plus populaires !"
                        src="assets/img/chat3.jpg">
                    <figcaption> Encore un autre Chat </figcaption>
                    <div class="rating">
                        <span>☆</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span>
                    </div>
            </figure>
        </div>
    </section>


    <section>
        <h3> Apercu de la boutique </h3>
        <header>
            <h4> Quelques oeuvres disponibles à la boutique : </h4>
        </header>
        <div class="shopview">
            <figure><a href="assets/img/chat1.jpg" target="_blank"> <img alt="une des oeuvre les plus populaires !"
                        src="assets/img/chat1.jpg">
                    <figcaption> Un Chat </figcaption>
                </a>
                <div class="rating">
                    <span>☆</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span>
                </div>
            </figure>
            <figure> <img alt="une des oeuvre les plus populaires !" src="assets/img/chat2.jpg">
                <figcaption> Un autre Chat </figcaption>
                <div class="rating">
                    <span>☆</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span>
                </div>
            </figure>
            <figure> <img alt="une des oeuvre les plus populaires !" src="assets/img/chat3.jpg">
                <figcaption> Encore un autre Chat </figcaption>
                <div class="rating">
                    <span>☆</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span>
                </div>
            </figure>
        </div>
    </section>
</main>

<?php include('template/footer.php'); ?>