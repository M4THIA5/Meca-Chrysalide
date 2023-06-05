<?php session_start(); ?>

<?php require('core/functions.php'); ?>
<?php require('conf.inc.php'); ?>
<?php include('template/head.php'); ?>
<?php include('template/navbar.php'); ?>
<?php redirectIfNotConnected(); ?>

<h1> Commandes passées </h1>

<?php

$connect = connectDB();
if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];

} else {

    $sort = 'idCommande';
}
$sortBy = isset($_GET['sort']) ? $_GET['sort'] : 'idCommande';
$sortOrder = isset($_GET['order']) && $_GET['order'] === 'desc' ? 'DESC' : 'ASC';

$queryPrepared = $connect->prepare("SELECT c.idCommande, c.dateCommande, u.nom, u.prenom, u.email, p.nomProduit, p.idProduit, c.est_acceptee
FROM " . DB_PREFIX . "commande c
INNER JOIN " . DB_PREFIX . "utilisateur u ON c.fkIdUtilisateur = u.id
INNER JOIN " . DB_PREFIX . "produit p ON c.fkIdProduit = p.idProduit
INNER JOIN " . DB_PREFIX . "coordonnees coord ON c.fkIdCoordonnees = coord.idCo
ORDER BY c.dateCommande DESC;"
);
$queryPrepared->execute();
$results = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
echo '<table>
        <tr>
            <th>' . generateSortLink('ID Commande', 'idCommande') . '</th>
            <th>' . generateSortLink('Date Commande', 'dateCommande') . '</th>
            <th>' . generateSortLink('Nom', 'nom') . '</th>
            <th>' . generateSortLink('Prénom', 'prenom') . '</th>
            <th>' . generateSortLink('Email', 'email') . '</th>
            <th>' . generateSortLink('Nom Produit', 'nomProduit') . '</th>
            <th>Action</th>
        </tr>';

foreach ($results as $commande) {
    echo '<tr>
            <td>' . $commande['idCommande'] . '</td>
            <td>' . $commande['dateCommande'] . '</td>
            <td>' . $commande['nom'] . '</td>
            <td>' . $commande['prenom'] . '</td>
            <td>' . $commande['email'] . '</td>
            <td>' . $commande['nomProduit'] . '</td>
            <td>
                <form action="core/acceptCommand.php" method="post">
                    <input type="hidden" name="idCommande" value="' . $commande['idCommande'] . '">
                    <input type="submit" value="Accepter">
                </form>
            </td>
          </tr>';
}

echo '</table>';