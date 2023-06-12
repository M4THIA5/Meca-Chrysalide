<?php session_start();
include_once('../conf.inc.php');
require_once('../core/functions.php');
require_once('../template/head.php');
include_once('../template/navbar.php'); ?>

<h2> Votre Profil </h2>
<?php
$connect = connectDB();
$queryPrepared = $connect->prepare("SELECT * FROM " . DB_PREFIX . "utilisateur where email=:email");
$queryPrepared->execute([
    "email" => $_SESSION["email"]
]);
$results = $queryPrepared->fetch();

echo '<section class="recapProfil"> 
    <h3> Informations personnelles </h3>
    <p><b><u> Prénom :</u></b> ' . $results["prenom"] . '</p>
    <p> <b><u>Nom :</u></b> ' . $results["nom"] . '</p>
    <p> <b><u>Email :</u></b> ' . $results["email"] . '</p>
    <p> <b><u>Date de naissance :</u></b> ' . $results["anniversaire"] . '</p>
    <p> <b><u>Date d\'inscription :</u></b> ' . $results["dateInscription"] . '</p>
    
    <a href="profileModify.php"><button type="button">Modifier</button>
    </a>
            
    </section>'; ?>

<?php
$connect = connectDB();
$queryPrepared = $connect->prepare("
    SELECT c.idCommande, c.dateCommande, c.est_acceptee, p.nomProduit, u.nom, u.prenom, u.email, coord.telephone
    FROM " . DB_PREFIX . "commande c
    INNER JOIN " . DB_PREFIX . "utilisateur u ON c.fkIdUtilisateur = u.id
    INNER JOIN " . DB_PREFIX . "produit p ON c.fkIdProduit = p.idProduit
    INNER JOIN " . DB_PREFIX . "coordonnees coord ON c.fkIdCoordonnees = coord.idCo
    WHERE c.fkIdUtilisateur = :idUtilisateur
");
$queryPrepared->execute([
    "idUtilisateur" => $_SESSION["user_id"]
]);
$results = $queryPrepared->fetchAll();


?>
<h3> Vos commandes </h3>
<?php
if (isset($_SESSION["succes_message"])) {
    echo "<p style='color: green'>" . $_SESSION["succes_message"] . "</p>";
    unset($_SESSION["succes_message"]);
}
foreach ($results as $result) {
    echo '<section class="recapCommande">
        <H4> <b><u>Nom du produit  </u></b>: ' . $result["nomProduit"] . '</h4>
        <p> <b><u>Date de commande </u></b>: ' . $result["dateCommande"] . '</p>';
    $status = "";
    switch ($result["est_acceptee"]) {
        case "0":
            $status = "En attente";
            break;
        case "1":
            $status = "<span style='color: green'>Acceptée</span>";
            break;
        case "-1":
            $status = "<span style='color: red'>Refusée</span>";
            break;
        default:
            $status = "Inconnu";
            break;
    }

    echo '<p> <b><u>Statut </u></b>: ' . $status . '</p>
    <p> <b><u>Numéro de commande </u></b> :' . $result["idCommande"] . '</p>
        <p> <b><u>Nom :</u></b> ' . $result["nom"] . '</p>
        <p> <b><u>Prénom </u></b>: ' . $result["prenom"] . '</p>
        <p> <b><u>Email </u></b>: ' . $result["email"] . '</p>
        <p> <b><u>Téléphone </u></b>: ' . $result["telephone"] . '</p>
        <form action="cancelOrder.php" method="post">
        <input type="hidden" name="idCommande" value="' . $result['idCommande'] . '; ?>">
        <button type="submit">Annuler la commande</button>
        </section>';
}
;
?>