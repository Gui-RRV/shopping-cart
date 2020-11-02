<?php 
//Lien avec la BDD
//Link to The DataBase
include 'connexion.php';

//In this project, validating your cart resets it while in real life you would be directed on a secured webpage to conclude your order.
//Dans ce projet, valider le panier le remets à zero alors que dans une vraie situation l'utilisateur serait redirigé sur une page web sécurisé pour finaliser la commande.

session_start();
$usr=$_SESSION['user'];

if (!isset($_SESSION['user'])) {
	setcookie('cart', NULL, -1);
	
	header('location:index.php');

}elseif(isset($_SESSION['user'])){
	$sth=$dbh->prepare("DELETE FROM cart WHERE user_id = ?");
	$sth->execute(array($usr));
	
	header('location:index.php');
}

 ?>