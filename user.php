<?php 
//Ce fichier sert à remplacer un système d'authentification pour fluidifier le travail, en production réelle on utiliserais la BDD pour stocker les informations de l'utilisateur et un système de hashage pour cryper le mot de passe
//This file replace an authentication system to help make the work faster, in production we'd the DataBase to stock user's data and we'd hash his Password 

session_start();

$_SESSION['user']=1;

header('location:index.php');

 ?>