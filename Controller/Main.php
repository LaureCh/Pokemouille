<?php
$step=0;
include ('../Model/Pokemon.php');
include('../Model/Dresseur.php');

if (isset($_POST['form-pseudo'])) {
  $dresseur = new Dresseur($_POST['name']);
  $step = 1;
}
if(isset($_POST['form-select'])) {
  $step = 2;
}
if(isset($_POST['form-clear'])) {
  $step = 0;
}

include('../Vue/index.php');

$opponentNames = parse_ini_file('../config.ini', true)['OPPONENTS'];
$randomInt= rand(0, count($opponentNames['opponents'])-1);
$opponent = new Dresseur($opponentNames['opponents'][$randomInt]);
var_dump($opponent); die;

$pokemonNames = parse_ini_file('./config.ini', true)['POKEMONS'];
$opponent = 'hello';
//$pokemon1 = new Pokemon('pikachu');
//var_dump($pokemon1);
//if (isset($_POST['name'])){
//    var_dump($_POST['name']);
//}
//var_dump($pokemon1);



?>
