<?php
require_once('functions.php');
require_once('../conf.inc.php');

$connect = connectDB();
$searchInput = $_GET['search'];
if (empty($searchInput)) {
    $searchInput = "";
} else {
    $queryprepared = $connect->prepare("SELECT * FROM " . DB_PREFIX . "utilisateur WHERE nom LIKE ? OR email LIKE ? OR prenom LIKE ?");
    $queryprepared->execute(array("%$searchInput%", "%$searchInput%", "%$searchInput%"));
    $listOfUsers = $queryprepared->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <table class="panneauUtilisateurs">




        <tbody class="searchusers">
            <?php
            foreach ($listOfUsers as $user) {
                echo "<tr>";
                echo "<td>" . $user["id"] . "</td>";
                echo "<td>" . $user["prenom"] . "</td>";
                echo "<td>" . $user["nom"] . "</td>";
                echo "<td>" . $user["email"] . "</td>";
                echo "<td>" . $user["anniversaire"] . "</td>";
                echo "<td>" . $user["dateInscription"] . "</td>";
                echo "<td><a href='../core/removeUser.php?id=" . $user["id"] . "'>Supprimer</a></td>";
                echo "<td>";
                if ($user['droitAdmin'] == 1) {
                    echo "<a class='promote-link' data-id='" . $user["id"] . "' href='../core/promoteUser.php?id=" . $user["id"] . "'>Rétrograder</a>";
                } else {
                    echo "<a class='promote-link' data-id='" . $user["id"] . "' href='../core/promoteUser.php?id=" . $user["id"] . "'>Promouvoir</a>";
                }
                echo "</td>";
                echo "</tr>";
            }

            ?>

        </tbody>
    </table>
    <?php
}
?>