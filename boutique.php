<?php session_start();
require('core/functions.php');
require('conf.inc.php');
include('template/head.php');
include('template/navbar.php'); 
redirectIfNotConnected();
?>

<h1> Boutique </h1>

<h3> Ici, vous pouvez acquérir une des oeuvres disponibles et ainsi soutenir l'artsite ! </h2>

    <section>
        <h4> Oeuvres disponibles </h4>
        <div class="boutique">
            <figure> <img alt="une des oeuvre les plus populaires !" src="assets/img/chat1.jpg">
                <figcaption> Un Chat </figcaption>
                <h4> Prix : 1000€ </h4>
                </a>
                <div class="rating">
                    <span>☆</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span>
                </div>
            </figure>
            <figure> <img alt="une des oeuvre les plus populaires !" src="assets/img/chat2.jpg">
                <figcaption> Un autre Chat </figcaption>
                <h4> Prix : 890€ </h4>
                <div class="rating">
                    <span>☆</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span>
                </div>
            </figure>
            <figure> <img alt="une des oeuvre les plus populaires !" src="assets/img/chat3.jpg">
                <figcaption> Encore un autre Chat </figcaption>
                <h4> Prix : 450€ </h4>
                <div class="rating">
                    <span>☆</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span>
                </div>
            </figure>
            <figure> <img alt="une des oeuvre les plus populaires !" src="assets/img/chat3.jpg">
                <figcaption> Encore un autre Chat </figcaption>
                <h4> Prix : 450€ </h4>
                <div class="rating">
                    <span>☆</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span>
                </div>
            </figure>
            <figure> <img alt="une des oeuvre les plus populaires !" src="assets/img/chat3.jpg">
                <figcaption> Encore un autre Chat </figcaption>
                <h4> Prix : 450€ </h4>
                <div class="rating">
                    <span>☆</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span>
                </div>
            </figure>
            <figure> <img alt="une des oeuvre les plus populaires !" src="assets/img/chat3.jpg">
                <figcaption> Encore un autre Chat </figcaption>
                <h4> Prix : 450€ </h4>
                <div class="rating">
                    <span>☆</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span>
                </div>
            </figure>
        </div>
    </section>

    <?php include('template/footer.php'); ?>