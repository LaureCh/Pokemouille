<?php
session_start();

CONST MOCK_ATTACKS = [
  1 => [
    'damage' => 10,
    'accuracy' => 100
  ],
  2 => [
    'damage' => 20,
    'accuracy' => 80
  ],
  3 => [
    'damage' => 10,
    'accuracy' => 100
  ],
  4 => [
    'damage' => 40,
    'accuracy' => 80
  ],
  5 => [
    'damage' => 50,
    'accuracy' => 70
  ],
  6 => [
    'damage' => 60,
    'accuracy' => 50
  ],
  7 => [
    'damage' => 70,
    'accuracy' => 40
  ],
  8 => [
    'damage' => 80,
    'accuracy' => 20
  ],
  9 => [
    'damage' => 90,
    'accuracy' => 20
  ],
  10 => [
    'damage' => 100,
    'accuracy' => 5
  ],
];

if(!empty($_POST['attack'])){

  // Recovery battle state
  $dresseur = $_SESSION['battle']['dresseur'];
  $opponent = $_SESSION['battle']['opponent'];
  $dresseurPokemon = $dresseur['pokemons'][$dresseur['pokemonActif']];
  $opponentPokemon = $opponent['pokemons'][$opponent['pokemonActif']];
  $nextPokemonDresseur = null;
  $nextPokemonOpponent = null;

  // Dresseur's turn
  if(isAttackMissed($_SESSION['attackList'][$_POST['attack']]['accuracy'])){
    $isDresseurAttackMissed = true;
  }else{
    $isDresseurAttackMissed = false;

    // Opponent takes damage
    $opponentPokemon['hp'] = calculatesHp($opponentPokemon['hp'], $_SESSION['attackList'][$_POST['attack']]['damage']);

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
  $opponentAttack = 3; //TODO to change by a random pokemon opponent attack
  if(isAttackMissed($_SESSION['attackList'][$opponentAttack]['accuracy'])){
    $isOpponentAttackMissed = true;
  }else{
    $isOpponentAttackMissed = false;

    // Dresseur takes damage
    $dresseurPokemon['hp'] = calculatesHp($dresseurPokemon['hp'], $_SESSION['attackList'][$opponentAttack]['damage']);

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
      'hp' => $dresseurPokemon['hp'],
      'xp' => 0,
      'isAttackMissed' => $isDresseurAttackMissed,
      'nextPokemon' => $nextPokemonDresseur
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
