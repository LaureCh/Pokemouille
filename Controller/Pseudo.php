<?php
session_start();
include('../Model/Dresseur.php');
include('../Model/Pokemon.php');
include('../Model/PokemonFille.php');
include('../Model/PokemonFilleInGame.php');
include('DBPower.php');

if (isset($_POST['name'])) {

    $return = array();
    $db = new DBPower();
    $response = $db->getPokemonsDresseur($_POST['name']);
    $dresseur = new Dresseur($_POST['name']);

    if(!$response){ // pas de dresseur dans BDD, new PLAYER
      $return['isNewPlayer'] = true;
      $return['dresseur'] = new Dresseur($_POST['name']);
      $_SESSION['step'] = 1;
    }else{
      foreach ($response as $value) {
        $pokemon = new PokemonFilleInGame();
        $pokemon->setIdPokemon((int)$value["id_pokemon"]);
        $pokemon->setXp((int)$value["xp"]);
        $pokemon->setName($_SESSION['pokemonList'][$value['id_pokemon']]['french_name']);
        $pokemon->setHp($_SESSION['pokemonList'][$value['id_pokemon']]['life_max']);
        $pokemon->setImg($_SESSION['pokemonList'][$value['id_pokemon']]['back_image_url']);
        $pokemons[]=(array)$pokemon;
      }

      //$dresseur->setPokemons($pokemons);
      $return['dresseur'] = (array)$dresseur;
      $return['dresseur']['pokemons'] = $pokemons; // TODO replace by -> setPokemons()
      $return['isNewPlayer'] = false;
      $_SESSION['step'] = 2;
    }




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
    $pokemonsOpponent[]=(array)$pokemon;
  }
  //$opponent->setPokemons($pokemonsOpponent);
  $return['opponent'] = (array)$opponent;
  $return['opponent']['pokemons'] = $pokemonsOpponent; // TODO replace by -> setPokemons()

  echo json_encode($return);
}
?>
