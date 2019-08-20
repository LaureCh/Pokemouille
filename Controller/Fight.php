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
    'damage' => 30,
    'accuracy' => 80
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

  // Dresseur's turn
  if(isAttackMissed(MOCK_ATTACKS[$_POST['attack']]['accuracy'])){
    $isDresseurAttackMissed = true;
  }else{
    $isDresseurAttackMissed = false;

    // Opponent takes damage
    $opponentPokemon['hp'] = calculatesHp($opponentPokemon['hp'], MOCK_ATTACKS[$_POST['attack']]['damage']);
  }

  //TODO check if he's dead
  //if($opponentPokemon['hp'] == 0)
  // switch pokemon opponent
  // add xp dresseur
  //TODO check they're all dead
  //return end of battle

  // Opponent's turn
  $opponentAttack = 3; //TODO to change
  if(isAttackMissed(MOCK_ATTACKS[$opponentAttack]['accuracy'])){
    $isOpponentAttackMissed = true;
  }else{
    $isOpponentAttackMissed = false;

    // Dresseur takes damage
    $dresseurPokemon['hp'] = calculatesHp($dresseurPokemon['hp'], MOCK_ATTACKS[$opponentAttack]['damage']);
  }

  //TODO check if he's dead
  //if($dresseurPokemon['hp'] == 0)
  // switch pokemon dresseur
  //TODO check they're all dead
  //return end of battle

  // Save battle
  $_SESSION['battle']['dresseur']['pokemons'][$dresseur['pokemonActif']]['hp'] = $dresseurPokemon['hp'];
  $_SESSION['battle']['opponent']['pokemons'][$opponent['pokemonActif']]['hp'] = $opponentPokemon['hp'];

  //TODO switch pokemon

  $return = [
    'dresseur' => [
      'hp' => $dresseurPokemon['hp'],
      'xp' => 0,
      'isAttackMissed' => $isDresseurAttackMissed,
    ],
    'opponent' => [
      'attackUsed' => $opponentAttack,
      'hp' => $opponentPokemon['hp'],
      'isAttackMissed' => $isOpponentAttackMissed,
      'nextPokemon' => null
    ]
  ];
  echo json_encode($return);
}
else{
  echo "Attaque introuvable";
}

function isAttackMissed($accuracy){
  return false;
}

function calculatesHp($hp, $damage){
  return (($hp - (int)$damage) < 0) ? 0 : $hp - (int)$damage;
}

/*function isDead(){

}

function endOfBattle(){

}*/



?>
