<?php 
//Lien avec la BDD
//Link to The DataBase
include "connexion.php";
session_start();

$id = $_POST['id'];
$qty = $_POST['qty'];
$usr=$_SESSION['user'];
$count=0;
$cart=array();


//Ici on vérifie si l'tuilisateur est connecté ou non, si il n'est pas connecté on utilise un système de cookies pour gérer le panier
//We  check if the user is connected or not, if not we use cookies to manage the cart
if (!isset($_SESSION['user'])) {

	if (isset($_COOKIE['cart'])) {
		$cart=unserialize($_COOKIE['cart']);
		
		for ($i=0; $i < count($cart) ; $i++) { 
			
			if ($id==$cart[$i]['id']) {
				echo "oui";
				$cart[$i]['quantité']=$qty+$cart[$i]['quantité'];
				
				unset($id);
				unset($qty);
				
			}
		}

		echo "count :".$count;

		if (isset($id) && isset($qty)) {
			array_push($cart, array('id' => $id , 'quantité' => $qty)); 
		}


		print_r($cart);
		


		setcookie('cart', serialize($cart) , time() + 1*60*60);
	}else{
		array_push($cart,array('id' => $id , 'quantité' => $qty));
		setcookie('cart', serialize($cart) , time() + 1*60*60);
	}
}elseif(isset($_SESSION['user'])){

	//L'utilisateur est connecté alors on utilise la BDD pour gérer son panier
	//The user is connected so we use the DataBase to manage his cart
	
	$sth=$dbh->prepare('SELECT * FROM cart WHERE id = ? AND user_id = ?');
	$sth->execute([$id,$usr]);
	$tab=$sth->fetch();

	//Permet de compter si la requête est vide ou non, si elle est vide cela signifie qu'il n'y a pas de quantité à mettre à jour sinon on la met à jour 
	$count=$sth->rowCount();
	if ($count == 0) {
		
		$sth=$dbh->prepare('INSERT INTO cart (user_id,qty,id) VALUES (:usr,:qty,:id)');
		$valeurs = array('usr'=> $usr,
						 'qty'=> $qty,
						 'id' => $id);
		$sth->execute($valeurs);
	}else{
		//Calcul de la nouvelle quantité
		$NewQty=$qty+$tab['qty'];
		//Mise a jour du panier
		$sth=$dbh->prepare('UPDATE cart SET qty= ? WHERE id = ? AND user_id = ?');
		$sth->execute([$NewQty,$id,$usr]);
	}
	
}


header('location:cart.php');

 ?>


