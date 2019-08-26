<?php
session_start();
if(isset($_POST['attack'])){

  // Recovery battle state
  $dresseur = $_SESSION['battle']['dresseur'];
  $opponent = $_SESSION['battle']['opponent'];
  $dresseurPokemon = $dresseur['pokemons'][$dresseur['pokemonActif']];
  $opponentPokemon = $opponent['pokemons'][$opponent['pokemonActif']];
  $nextPokemonDresseur = null;
  $nextPokemonOpponent = null;

  // Dresseur's turn
  $dresseurAttack = $dresseurPokemon['attack'][$_POST['attack']];
  if(isAttackMissed($dresseurAttack['accuracy'])){
    $isDresseurAttackMissed = true;
  }else{
    $isDresseurAttackMissed = false;

    // Opponent takes damage
    $opponentPokemon['hp'] = calculatesHp($opponentPokemon['hp'], $dresseurAttack['damages']);

    // Saves HP
    $_SESSION['battle']['opponent']['pokemons'][$opponent['pokemonActif']]['hp'] = $opponentPokemon['hp'];
  }

  // Checks if he's dead
  if($opponentPokemon['hp'] == 0){
    $opponent['pokemonActif'] = (int)nextPokemon((int)$opponent['pokemonActif'], true);
    $nextPokemonOpponent = $opponent['pokemonActif'];
    $opponentPokemon = $opponent['pokemons'][$nextPokemonOpponent];

    // Saves switch pokemon
    $_SESSION['battle']['opponent']['pokemonActif'] = $nextPokemonOpponent;
    // add xp dresseur
  }

  // Opponent's turn
  $opponentAttack = $opponentPokemon['attack'][rand(0, 2)];
  //$opponentAttack = 3;
  if(isAttackMissed($opponentAttack['accuracy'])){
    $isOpponentAttackMissed = true;
  }else{
    $isOpponentAttackMissed = false;

    // Dresseur takes damage
    $dresseurPokemon['hp'] = calculatesHp($dresseurPokemon['hp'], $opponentAttack['damages']);

    // Saves HP
    $_SESSION['battle']['dresseur']['pokemons'][$dresseur['pokemonActif']]['hp'] = $dresseurPokemon['hp'];
  }

  // Checks if he's dead
  if($dresseurPokemon['hp'] == 0){
    $dresseur['pokemonActif'] = nextPokemon((int)$dresseur['pokemonActif']);
    $nextPokemonDresseur = $dresseur['pokemonActif'];
    $dresseurPokemon = $dresseur['pokemons'][$nextPokemonDresseur];

    // Saves switch pokemon
    $_SESSION['battle']['dresseur']['pokemonActif'] = $nextPokemonDresseur;
  }

  $return = [
    'dresseur' => [
      'attackUsed' => $dresseurAttack,
      'hp' => $dresseurPokemon['hp'],
      'isAttackMissed' => $isDresseurAttackMissed,
      'nextPokemon' => $nextPokemonDresseur,
      'xp' => 0,
    ],
    'opponent' => [
      'attackUsed' => $opponentAttack,
      'hp' => $opponentPokemon['hp'],
      'isAttackMissed' => $isOpponentAttackMissed,
      'nextPokemon' => $nextPokemonOpponent
    ]
  ];
  echo json_encode($return);
}
else{
  echo "Attaque introuvable";
}

function isAttackMissed($accuracy){
  return ((random_int(0, 100)) < $accuracy) ? false : true;
}

function calculatesHp($hp, $damage){
  return (($hp - (int)$damage) < 0) ? 0 : $hp - (int)$damage;
}

function nextPokemon($token, $isOpponent = false){
  return ($token < 2) ? $token + 1 : endOfBattle($isOpponent);
}

function endOfBattle($isOpponent = false){
  return ($isOpponent) ? 'Vous avez perdu.' : 'Vous avez gagné !';
}

?>
