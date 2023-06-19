<?php session_start();
require('../core/functions.php');
require('../conf.inc.php');
include('../template/head.php');
include('../template/navbar.php');
// Requete pour afficher les signalements, leur auteur, et qui les as signalés
$connect = connectDB();
$query = "SELECT s.id, c.commentaire, CASE WHEN u.id IS NULL THEN 'Utilisateur supprimé' ELSE CONCAT(u.nom, ' ', u.prenom) END AS auteur, CONCAT(u2.nom, ' ', u2.prenom) AS signaleur, s.traitee
          FROM " . DB_PREFIX . "signalements s
          JOIN " . DB_PREFIX . "commentaires c ON s.fk_id_commentaire = c.id
          LEFT JOIN " . DB_PREFIX . "utilisateur u ON c.fk_id_utilisateur = u.id
          JOIN " . DB_PREFIX . "utilisateur u2 ON s.signaleur = u2.id";



$stmt = $connect->prepare($query);
$stmt->execute();

$signalements = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>


<h2>Signalements</h2>
<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Commentaire</th>
            <th>Auteur</th>
            <th>Signaleur</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($signalements as $signalement): ?>
            <tr>
                <td>
                    <?php echo $signalement['id']; ?>
                </td>
                <td>
                    <?php echo $signalement['commentaire']; ?>
                </td>
                <td>
                    <?php echo $signalement['auteur']; ?>
                </td>
                <td>
                    <?php echo $signalement['signaleur']; ?>
                </td>
                <td>
                    <!-- Si le signalement est traité, on affiche un message, sinon on affiche les boutons supprimer et traiter -->
                    <?php if ($signalement['traitee'] == 0) { ?>
                        <a href="../core/supprimerSignalement.php?id=<?php echo $signalement['id']; ?>">Supprimer</a>
                        <a href="../core/traiterSignalement.php?id=<?php echo $signalement['id']; ?>">Traiter</a>
                    </td>
                </tr>
            <?php } else { ?>
                <p class="accepted"> Traité
                <?php }
        endforeach; ?>
    </tbody>
</table>
<?php include('../template/footer.php'); ?>