<?php
//Lien avec la BDD
//Link to The DataBase
include "connexion.php";
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<title>Bienvenue dans votre magasin de ses morts !</title>
	 <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

	<link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
	<div class="site-container">
			<header class="site-header">
			<a href="AjoutProduit.php">Et si on ajouté un nouveau produit ?</a>
			<?php if (isset($_SESSION['user'])) {
				echo $_SESSION['user']. ' VOUS ETES CONNECTES';
				echo '<a href="deco.php">je m\'en vais</a>';
			}else{
				echo '<a href="user.php">Je me connecte à mon compte fictif !</a>';
			} ?>
			</header>
			<main class="site-content">
		<h1>Bienvenue dans le e-commerce !</h1>
		<p> voici nos articles </p>

		<?php

		$sth=$dbh->query("SELECT * FROM produits");

		while ($row=$sth->fetch()) {
			echo '<div class="container">';
			echo '<h2>'.$row['Nom'].'</h2>';
			echo '<img id="img" src="'.$row['img'].'">';
			echo '<p>'.$row['Description'].'</p>';
			echo '<p> Prix: <b>'.$row['Prix'].'</b> €</p>';
			echo '<form method="post" action="ajout.php"><input type="number" min="1" max="10" id="qty" name="qty" required  ><input type="submit" name="btn" value="Ajouter cet objet dans votre panier !">  <input type="hidden" name="id" value="'.$row['id'].'"></form>';


			echo '</div>';
		}
		
		  ?>
		</main> 
		<footer class="site-footer"></footer>
	</div>
</body>
</html>