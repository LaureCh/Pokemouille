<?php
session_start();
include('DBPower.php');
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
    $opponent['pokemonActif'] = (int)nextPokemon((int)$opponent['pokemonActif']);
    $nextPokemonOpponent = $opponent['pokemonActif'];

    // Adds XP
    $xpEarned = rand(5, 40); // XP earned calcul
    $dresseurPokemonXp = calculatesXp($dresseurPokemonXp, $xpEarned);
    // Saves XP
    $_SESSION['battle']['dresseur']['pokemons'][$dresseur['pokemonActif']]['xp'] = $dresseurPokemonXp;

    // Checks if battle is ended - Dresseur VICTORY
    if($opponent['pokemonActif'] == -1){
      bonusXpVictory();
      endOfBattle();
    }else{
      $opponentPokemon = $opponent['pokemons'][$nextPokemonOpponent];

      // Saves switch pokemon
      $_SESSION['battle']['opponent']['pokemonActif'] = $nextPokemonOpponent;
    }
  }

  if($nextPokemonOpponent != -1){
    // Opponent's turn
    $opponentAttack = $opponentPokemon['attack'][rand(0, 2)];
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
      $dresseur['pokemonActif'] = (int)nextPokemon((int)$dresseur['pokemonActif']);
      $nextPokemonDresseur = $dresseur['pokemonActif'];

      // Checks if battle is ended - Opponent VICTORY
      if($dresseur['pokemonActif'] == -1){
        endOfBattle();
      }else{
          $dresseurPokemon = $dresseur['pokemons'][$nextPokemonDresseur];

          // Saves switch pokemon
          $_SESSION['battle']['dresseur']['pokemonActif'] = $nextPokemonDresseur;
      }
    }
  }else{
    $opponentAttack = null;
    $isOpponentAttackMissed = null;
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

function calculatesXp($xp, $xpEarned){
  return (($xp + (int)$xpEarned) > 100) ? 100 : $xp + (int)$xpEarned;
}

function nextPokemon($token){
  return ($token++ < 2) ? $token++ : -1;
}

function bonusXpVictory(){
  foreach ($_SESSION['battle']['dresseur']['pokemons'] as $i => $p) {
      $_SESSION['battle']['dresseur']['pokemons'][$i]['xp'] = calculatesXp($_SESSION['battle']['dresseur']['pokemons'][$i]['xp'], 20);
  }
}

function endOfBattle(){
  foreach ($_SESSION['battle']['dresseur']['pokemons'] as $i => $p) {
    if($p['xp'] == 100){
      // TODO evolution(s)
      $_SESSION['battle']['dresseur']['pokemons'][$i]['xp'] = 0;
    }
  }
  $db = new DBPower();
  $response = $db->updateXp($_SESSION['battle']['dresseur']['pokemons']);
}

?>
