<?php
session_start();
include('../Model/Dresseur.php');
include('../Model/Pokemon.php');
include('../Model/PokemonFille.php');
include('../Model/PokemonFilleInGame.php');
include('../Model/Attack.php');
include('DBPower.php');

function completeAttacks($attacks){
  $a = [];
  foreach ($attacks as $v) {
    $attack = new Attack();
    $attack->setIdAttack($v['id_attack']);
    $attack->setName($v['name']);
    $attack->setDamages($v['damage']);
    $attack->setAccuracy($v['accuracy']);
    $attack->setDescription($v['description']);

    $a[]=(array)$attack;
  }
  return $a;
}

if (isset($_POST['name'])) {
  $return = array();
  $db = new DBPower();
  $response = $db->getPokemonsDresseur($_POST['name']);
  $dresseur = new Dresseur($_POST['name']);

  if(!$response){ // pas de dresseur dans BDD, new PLAYER
    $return['isNewPlayer'] = true;
    $return['dresseur'] = (array)$dresseur;
  }else{
    foreach ($response as $value) {
      $pokemon = new PokemonFilleInGame();
      $pokemon->setId((int)$value["id_pokemon_fille"]);
      $pokemon->setIdPokemon((int)$value["id_pokemon"]);
      $pokemon->setXp((int)$value["xp"]);
      $pokemon->setName($_SESSION['pokemonList'][$value['id_pokemon']]['french_name']);
      $pokemon->setHp($_SESSION['pokemonList'][$value['id_pokemon']]['life_max']);
      $pokemon->setImg($_SESSION['pokemonList'][$value['id_pokemon']]['back_image_url']);

      $pokemon=(array)$pokemon;

      $attacksResponse = $db->getAttacksFromPokemon($value["id_pokemon"]);
      $pokemon['attack'] = completeAttacks($attacksResponse);

      $pokemons[]=$pokemon;
    }

    $return['dresseur'] = (array)$dresseur;
    $return['dresseur']['pokemons'] = $pokemons;
    $return['isNewPlayer'] = false;
  }

  // return opponent
  $opponentNames = parse_ini_file('../config.ini', true)['OPPONENTS'];
  $randomInt= rand(0, count($opponentNames['opponents'])-1);
  $opponent = new Dresseur($opponentNames['opponents'][$randomInt]);

  $pokemonIds = parse_ini_file('../config.ini', true)['POKEMONS']['pokemons'];
  $pokemonsIds = array_rand($pokemonIds, 3);

  $pokemonsForOpponent = $db->getPokemonsByIds($pokemonsIds);
  foreach ($pokemonsForOpponent as $value) {
    $pokemon = new PokemonFilleInGame();
    $pokemon->setIdPokemon((int)$value["id_pokemon"]);
    $pokemon->setName($_SESSION['pokemonList'][$value['id_pokemon']]['french_name']);
    $pokemon->setHp($_SESSION['pokemonList'][$value['id_pokemon']]['life_max']);
    $pokemon->setImg($_SESSION['pokemonList'][$value['id_pokemon']]['front_image_url']);

    $pokemon=(array)$pokemon;

    $attacksResponse = $db->getAttacksFromPokemon($value["id_pokemon"]);
    $pokemon['attack'] = completeAttacks($attacksResponse);

    $pokemonsOpponent[]=$pokemon;
  }
  $return['opponent'] = (array)$opponent;
  $return['opponent']['pokemons'] = $pokemonsOpponent;

  $_SESSION['battle'] = $return;
  echo json_encode($return);
}
?>
