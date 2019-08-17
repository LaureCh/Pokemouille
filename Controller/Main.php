<?php
include ('..\Model\Pokemon.php');
include('..\Vue\login.html');
include('..\Model\Dresseur.php');

//if (isset($_POST['username'])) {
//    $dresseur = new Dresseur($_POST['username']);
//}

$opponentNames = parse_ini_file('../config.ini', true)['OPPONENTS'];
$randomInt= rand(0, count($opponentNames['opponents']));
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



