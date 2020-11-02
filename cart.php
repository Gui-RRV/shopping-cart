<?php 
//Lien avec la BDD
//Link to The DataBase
include 'connexion.php';
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Votre panier</title>
		 <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="site-container">
		<header class="site-header">
			<p>Félicitations !</p>
		</header>
		<main class="site-content">
			<?php 
			if(!isset($_SESSION['user']) && !isset($_COOKIE['cart']) ){

				echo 'votre panier est vide ! ';
			}else{
				echo"<h1>Vous venez d'ajouter des articles ! </h1>";
			}
			
			
			



			if(!isset($_SESSION['user']) && !isset($_COOKIE['cart'])){
				echo 'cliquez <a href="index.php">ICI</a> pour débuter vos achats.';
			
			}elseif (!isset($_SESSION['user'])) {
				$cart=unserialize($_COOKIE['cart']);
							
							
					echo "<br>";
							

					foreach ($cart as $cart) {
								
						$id = $cart['id'];
								
						$sth=$dbh->prepare("SELECT * FROM produits WHERE id = ?");
						$sth->execute(array($id));
						$tab=$sth->fetchall();
								
								
						echo '<div class="container">';
						echo '<h2>'.$tab[0]['Nom'].'</h2>';
						echo '<img id="img" src="'.$tab[0]['img'].'">';
						echo '<p> Prix: <b>'.$tab[0]['Prix'].'</b> €</p>';
						echo 'vous en avez acheté: ' .$cart['quantité']. ' exemplaires !';

						echo '</div>';
								
								

					}




			}elseif (isset($_SESSION['user'])) {
				$id=$_SESSION['user'];
				$sth=$dbh->prepare('SELECT produits.id,cart.id,Nom,Description,Prix,qty,Genre,img FROM produits INNER JOIN cart ON produits.id=cart.id WHERE user_id = :id');
				$valeurs=array('id'=>$id);
				$sth->execute($valeurs);

				while ($row=$sth->fetch()) {
							echo '<div class="container">';
							echo '<h2>'.$row['Nom'].'</h2>';
							echo '<img id="img" src="'.$row['img'].'">';
							echo '<p> Prix: <b>'.$row['Prix'].'</b> €</p>';
							echo 'vous en avez acheté: ' .$row['qty']. ' exemplaires !';

							echo '</div>';
				}	
			}

			 ?>
			 <a href="index.php">Retour</a>
			 <a href="achat.php"> <hr>Je valide mon panier</a>

		</main> 
		<footer class="site-footer"></footer>
	</div>

</body>
</html>

