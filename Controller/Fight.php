<?php
session_start();
if(isset($_POST['attack'])){

  // Recovery battle state
  $dresseur = $_SESSION['battle']['dresseur'];
  $opponent = $_SESSION['battle']['opponent'];
  $dresseurPokemon = $dresseur['pokemons'][$dresseur['pokemonActif']];
  $opponentPokemon = $opponent['pokemons'][$opponent['pokemonActif']];
  $dresseurPokemonHp = $dresseurPokemon['hp'];
  $opponentPokemonHp = $opponentPokemon['hp'];
  $dresseurPokemonXp = $dresseurPokemon['xp'];
  $xpEarned = 0;
  $nextPokemonDresseur = null;
  $nextPokemonOpponent = null;

  // Dresseur's turn
  $dresseurAttack = $dresseurPokemon['attack'][$_POST['attack']];
  if(isAttackMissed($dresseurAttack['accuracy'])){
    $isDresseurAttackMissed = true;
  }else{
    $isDresseurAttackMissed = false;

    // Opponent takes damage
    $opponentPokemonHp = calculatesHp($opponentPokemonHp, $dresseurAttack['damages']);

    // Saves HP
    $_SESSION['battle']['opponent']['pokemons'][$opponent['pokemonActif']]['hp'] = $opponentPokemonHp;
  }

  // Checks if opponent pokemon is dead
  if($opponentPokemonHp == 0){
    $opponent['pokemonActif'] = (int)nextPokemon((int)$opponent['pokemonActif'], true);
    $nextPokemonOpponent = $opponent['pokemonActif'];
    $opponentPokemon = $opponent['pokemons'][$nextPokemonOpponent];

    // Saves switch pokemon
    $_SESSION['battle']['opponent']['pokemonActif'] = $nextPokemonOpponent;

    // Adds XP
    $xpEarned = rand(5, 40); // XP earned calcul
    $dresseurPokemonXp+=$xpEarned;
    // Saves XP
    $_SESSION['battle']['dresseur']['pokemons'][$dresseur['pokemonActif']]['xp'] = $dresseurPokemonXp;
  }

  // Opponent's turn
  $opponentAttack = $opponentPokemon['attack'][rand(0, 2)];
  //$opponentAttack = 3;
  if(isAttackMissed($opponentAttack['accuracy'])){
    $isOpponentAttackMissed = true;
  }else{
    $isOpponentAttackMissed = false;

    // Dresseur takes damage
    $dresseurPokemonHp = calculatesHp($dresseurPokemonHp, $opponentAttack['damages']);

    // Saves HP
    $_SESSION['battle']['dresseur']['pokemons'][$dresseur['pokemonActif']]['hp'] = $dresseurPokemonHp;
  }

  // Checks if dresseur pokemon is dead
  if($dresseurPokemonHp == 0){
    $dresseur['pokemonActif'] = nextPokemon((int)$dresseur['pokemonActif']);
    $nextPokemonDresseur = $dresseur['pokemonActif'];
    $dresseurPokemon = $dresseur['pokemons'][$nextPokemonDresseur];

    // Saves switch pokemon
    $_SESSION['battle']['dresseur']['pokemonActif'] = $nextPokemonDresseur;
  }

  $return = [
    'dresseur' => [
      'attackUsed' => $dresseurAttack,
      'hp' => $dresseurPokemonHp,
      'isAttackMissed' => $isDresseurAttackMissed,
      'nextPokemon' => $nextPokemonDresseur,
      'xp' => $dresseurPokemonXp,
      'xpEarned' => $xpEarned
    ],
    'opponent' => [
      'attackUsed' => $opponentAttack,
      'hp' => $opponentPokemonHp,
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
  // TODO SAVE XP POKEMON
  return ($isOpponent) ? 'Vous avez gagné !' : 'Vous avez perdu.';
}

?>
