<?php
session_start();
$step=0;
include('../Model/Pokemon.php');
include('../Model/Dresseur.php');
include('DBPower.php');

$db = new DBPower();
$response = $db->getPokemons();
$_SESSION['pokemonList'] = $response;

if(isset($_POST['form-clear'])) {
  $step = 0;
}

include('../Vue/index.php');


//$pokemon1 = new Pokemon('pikachu');
//var_dump($pokemon1);
//if (isset($_POST['name'])){
//    var_dump($_POST['name']);
//}
//var_dump($pokemon1);



?>
