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

if(isset($_POST['id'])) {
  // create new dresseur
  $db = new DBPower();
  $dresseurId = $db->createDresseur($_SESSION['battle']['dresseur']['username'], $_POST['id']);

  $return = array();
  $response = $db->getPokemonsDresseur($_SESSION['battle']['dresseur']['username']);
  $dresseur = new Dresseur($_SESSION['battle']['dresseur']['username']);

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

  $_SESSION['battle']['dresseur'] = $return['dresseur'];
  echo json_encode($return);
}
?>
