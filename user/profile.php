<?php 
session_start();
require('../core/functions.php');
require('../conf.inc.php');
include('../template/head.php');
include('../template/navbar.php');
redirectIfNotConnected();
?>

<h1> MON PROFILE </h1>

<<<<<<< HEAD
<?php

	$connect = connectDB();
	$queryPrepared = $connect->prepare("SELECT id, nom, prenom, email, anniversaire, telephone, dateInscription FROM ".DB_PREFIX."utilisateur WHERE email=:email" );
    $queryPrepared->execute(["email"=>$_SESSION["email"]]);
	$myUser = $queryPrepared->fetchAll();
    print_r($myUser);
?>

<table class="table">
		<thead>
			<tr>
				<th>Id</th>
				<th>Prénom</th>
				<th>Nom</th>
				<th>Email</th>
				<th>Date de naissance</th>
                <th>Téléphone</th>
				<th>Date d'insertion</th>
			</tr>
		</thead>
		<tbody>
			<?php /*
                echo "<tr>";

                echo "<td>".$user["id"]."</td>";
                echo "<td>".$user["prenom"]."</td>";
                echo "<td>".$user["nom"]."</td>";
                echo "<td>".$user["email"]."</td>";
                echo "<td>".$user["anniversaire"]."</td>";
                echo "<td>".$user["dateInscription"]."</td>";

                echo "</tr>";
			*/ ?>
            <tr>
                <td> <?php echo $myUser[0]?> </td>
            </tr>
		</tbody>
	</table>
<?php include('../template/footer.php'); ?>