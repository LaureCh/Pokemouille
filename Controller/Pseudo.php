<?php
include('../Model/Dresseur.php');
include('../Model/Pokemon.php');
include('DBPower.php');

if (isset($_POST['name'])) {

    $return = array();
    $db = new DBPower();
    $response = $db->checkDresseur($_POST['name']);
    $dresseur = new Dresseur($_POST['name']);

    if(!$response){ // pas de dresseur dans BDD, new PLAYER
      $return['isNewPlayer'] = true;
    }else{
      foreach ($response as $key => $value) {
        $pokemon = new Pokemon($value);
        $dresseur->addPokemon($pokemon);
      }
      $return['isNewPlayer'] = false;
    }





  //test si c'est un nouveau Dresseur
  if($_POST['name']=="Korben"){
    $dresseur = new Dresseur('Korben');
    $pokemon1 = new Pokemon('Pikachu');
    $pokemon2 = new Pokemon('Salamèche');
    $pokemon3 = new Pokemon('Dracaufeu');
    $pokemons=[(array)$pokemon1, (array)$pokemon2, (array)$pokemon3];

    $dresseur->setPokemons($pokemons);

    $return['dresseur'] = (array)$dresseur;

    //$return['dresseur']['pokemons'] = array(new Pokemon('Pikachu'),new Pokemon('Pikachu'),new Pokemon('Pikachu'));
    //$return['dresseur']['pokemons'][] = new Pokemon('Salamèche');
    //$return['dresseur']['pokemons'][] = new Pokemon('Caninos');
    echo json_encode($return);
  }else{
    $return['dresseur'] = new Dresseur($_POST['name']);
  }

  //$dresseur = new Dresseur($_POST['name']);
  $_SESSION['step'] = 1;
  // stocker en bdd le dresseur`
  $opponentNames = parse_ini_file('../config.ini', true)['OPPONENTS'];
  $randomInt= rand(0, count($opponentNames['opponents'])-1);
  $opponent = new Dresseur($opponentNames['opponents'][$randomInt]);


  $pokemonIds = parse_ini_file('../config.ini', true)['POKEMONS']['pokemons'];
  $pokemonsIds = array_rand($pokemonIds, 3);

  $pokemonsForOpponent = $db->getPokemons($pokemonsIds);


  $return['opponent'] = $opponent;
}
?>
