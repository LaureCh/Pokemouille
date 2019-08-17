<?php
include('../../Model/Dresseur.php');

if (isset($_POST['name'])) {
  $return[] = array();
  //test si c'est un nouveau Dresseur
  if($_POST['name']=="Korben"){
    $return['isNewPlayer'] = false;
    $return['dresseur'] = new Dresseur('Korben');
  }else{
    $return['dresseur'] = new Dresseur($_POST['name']);
    $return['isNewPlayer'] = true;
  }

  //$dresseur = new Dresseur($_POST['name']);
  $_SESSION['step'] = 1;
  // stocker en bdd le dresseur`
  $opponentNames = parse_ini_file('../../config.ini', true)['OPPONENTS'];
  $randomInt= rand(0, count($opponentNames['opponents'])-1);
  $opponent = new Dresseur($opponentNames['opponents'][$randomInt]);


  $pokemonNames = parse_ini_file('../../config.ini', true)['POKEMONS'];
  $pokemonsNames = array_rand($opponentNames['opponents'], 3);

  $return['opponent'] = $opponent;
  echo json_encode($return);
}
?>
