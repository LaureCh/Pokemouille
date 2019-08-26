<?php
session_start();
$step=0;
include('../Model/Pokemon.php');
include('../Model/Dresseur.php');
include('DBPower.php');

$db = new DBPower();
$pokemons = $db->getPokemons();
foreach ($pokemons as $p) {
  $_SESSION['pokemonList'][$p['id_pokemon']] = $p;
}

$attacks = $db->getAttacks();
foreach ($attacks as $a) {
  $_SESSION['attackList'][$a['id_attack']] = $a;
}

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
