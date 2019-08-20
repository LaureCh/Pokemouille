<?php
session_start();

$mockAttacks = [
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
  $attackId = (int) $_POST['attack'];

  // Prepares dresseur's attack
  $isDresseurAttackMissed = false;
  $damage = $mockAttacks[$attackId]['damage'];

  // TODO faire le test d'accuracy
  if(false){
    $isDresseurAttackMissed = true;
    $damage = 0;
  }

  // Battle
  $dresseur = $_SESSION['battle']['dresseur'];
  $opponent = $_SESSION['battle']['opponent'];

  $dresseurPokemon = $dresseur['pokemons'][$dresseur['pokemonActif']];
  $opponentPokemon = $opponent['pokemons'][$opponent['pokemonActif']];

  // Opponent take damage
  (($opponentPokemon['hp'] - (int)$damage) < 0) ? $opponentPokemon['hp'] = 0 : $opponentPokemon['hp'] = $opponentPokemon['hp'] - (int)$damage;

  //TODO check if he's dead
  //if($opponentPokemon['hp'] == 0)
  // switch pokemon opponent
  // add xp dresseur
  //TODO check they're all dead
  //return end of battle

  // Opponent attack
  $opponentAttack = 3; //TODO to change

  // Prepares opponent's attack
  $isOpponentAttackMissed = false;
  $damageOpponent = $mockAttacks[$opponentAttack]['damage'];

  // TODO faire le test d'accuracy
  if(false){
    $isOpponentAttackMissed = true;
    $damageOpponent = 0;
  }

  // Dresseur take damage
  ($dresseurPokemon['hp'] - (int)$damageOpponent < 0) ? $dresseurPokemon['hp'] = 0 : $dresseurPokemon['hp'] -= (int)$damageOpponent;

  //TODO check if he's dead
  //if($dresseurPokemon['hp'] == 0)
  // switch pokemon dresseur
  //TODO check they're all dead
  //return end of battle

  // Save battle

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
/*
function attack (){

}

function isDead(){

}

function endOfBattle(){

}*/



?>
