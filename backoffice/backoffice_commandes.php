<?php session_start(); ?>

<?php require('../core/functions.php'); ?>
<?php require('../conf.inc.php'); ?>
<?php include('../template/head.php'); ?>
<?php include('../template/navbar.php'); ?>
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

$orderClause = "ORDER BY p.nomProduit $sortOrder;";
$queryPrepared = $connect->prepare("SELECT c.idCommande, c.dateCommande, u.nom, u.prenom, u.email, p.nomProduit, p.idProduit, c.est_acceptee
    FROM " . DB_PREFIX . "commande c
    INNER JOIN " . DB_PREFIX . "utilisateur u ON c.fkIdUtilisateur = u.id
    INNER JOIN " . DB_PREFIX . "produit p ON c.fkIdProduit = p.idProduit
    INNER JOIN " . DB_PREFIX . "coordonnees coord ON c.fkIdCoordonnees = coord.idCo
    $orderClause"


);
$queryPrepared->execute();
$results = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
echo '<table>
        <tr class="entete">
            <th>' . generateSortLink('Nom Produit <br>(Id Commande)', 'nomProduit') . '</th>
            <th>' . generateSortLink('Date Commande', 'dateCommande') . '</th>
            <th>' . generateSortLink('Nom', 'nom') . '</th>
            <th>' . generateSortLink('Prénom', 'prenom') . '</th>
            <th>' . generateSortLink('Email', 'email') . '</th>
            <th>Action</th>
        </tr>';
$currentProduct = null;
foreach ($results as $commande) {
    if ($commande['nomProduit'] !== $currentProduct) {
        echo '<tr><td colspan="7" class="product-separator">' . $commande['nomProduit'] . '</td></tr>';
        $currentProduct = $commande['nomProduit'];
    }
    echo '<tr>
            <td>' . $commande['idCommande'] . '</td>
            <td>' . $commande['dateCommande'] . '</td>
            <td>' . $commande['nom'] . '</td>
            <td>' . $commande['prenom'] . '</td>
            <td>' . $commande['email'] . '</td>
            <td>' ?>
    <?php if ($commande['est_acceptee'] == '0') { ?>
        <form action="../core/acceptCommand.php" method="post">
            <input type="hidden" name="idCommande" value="<?php echo $commande['idCommande']; ?>">
            <input type="submit" value="Accepter">
        </form>
    <?php } elseif ($commande['est_acceptee'] == '1') { ?>
        <p class="approved">Acceptée</p>
    <?php } elseif ($commande['est_acceptee'] == '-1') { ?>
        <p class="denied">Refusée</p>
    <?php } ?>
    </td>
    </tr>
    <?php
}
echo '</table>

</table>';

include('../template/footer.php');
?>