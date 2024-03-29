var canvas = document.getElementById("fight");
var ctx = canvas.getContext("2d");

// init data
var dresseur = new Dresseur();
var opponent = new Dresseur();

// Battle info
var isBattleStarted = false;
var isBattleEnded = false;
var winner = null;
var looser = null;
var isPlayerWinner = null;

// Bar health
var barHealtwidth = 100;
var barHealtheight = 15;
var barHealtOffset = 10;

// Bar xp
var barXpwidth = 100;
var barXpheight = 3;
var barXpOffset = 10;

// Pokemon img position
var pokemonImgX = 15;
var pokemonImgXOpponent = canvas.width-96-15;
var pokemonImgY = 80;
var pokemonImgXAttacking = pokemonImgX;
var pokemonImgXOpponentAttacking = pokemonImgXOpponent;
var spacingImgDeath = (96-64)/2;

var move = 0;

function drawDresseurName(dresseurName, isOpponent = false){
  // Position
  var positionNameDresseurX = 10;
  ctx.textAlign = "left";
  if(isOpponent){
    var positionNameDresseurX = canvas.width-10;
    ctx.textAlign = "right";
  }

  // Pokemon name
  ctx.font = "16px Arial";
  ctx.fillStyle = "orange";
  ctx.fillText(dresseurName.toUpperCase(), positionNameDresseurX, 20);
  ctx.textAlign = "left";
}

function drawPokemonInfo(pokemon, isOpponent = false) {
  // Position
  var barPositionX = barHealtOffset;
  var barPositionY = barHealtOffset+40;
  if(isOpponent){
    var barPositionX = canvas.width-barHealtOffset-barHealtwidth;
  }

  // Pokemon name
  ctx.font = "16px Arial";
  ctx.fillStyle = "#0095DD";
  ctx.fillText(pokemon.name, barPositionX-8, 40);

  // Health bar
  var percent = 100-(pokemon.hp/pokemon.hpMax*100)
  ctx.beginPath();
  ctx.rect(barPositionX, barPositionY, barHealtwidth, barHealtheight);
  ctx.fillStyle = "lightblue";
  ctx.fill();
  ctx.closePath();
  ctx.beginPath();
  ctx.rect(barPositionX, barPositionY, barHealtwidth-percent, barHealtheight);
  ctx.fillStyle = "#0095DD";
  ctx.fill();
  ctx.closePath();

  // Health text
  ctx.font = "14px Arial";
  ctx.fillStyle = "#0095DD";
  ctx.fillText(pokemon.hp+' / '+pokemon.hpMax, barPositionX, 80);

  // Xp bar
  if(!isOpponent){
    var percentXp = 100-(pokemon.xp/100*100);
    ctx.beginPath();
    ctx.rect(barPositionX, barPositionY-barXpheight, barXpwidth, barXpheight);
    ctx.fillStyle = "pink";
    ctx.fill();
    ctx.closePath();
    ctx.beginPath();
    ctx.rect(barPositionX, barPositionY-barXpheight, barXpwidth-percentXp, barXpheight);
    ctx.fillStyle = "red";
    ctx.fill();
    ctx.closePath();
  }
}

function drawPokemon(){
  // Draw
  if(dresseur.pokemonActif != -1){
    $('#img-pokemon-dresseur').attr('src', dresseur.team[dresseur.pokemonActif].img);
    ctx.drawImage(document.getElementById('img-pokemon-dresseur'), pokemonImgXAttacking, pokemonImgY);
  }
  if(opponent.pokemonActif != -1){
    $('#img-pokemon-opponent').attr('src', opponent.team[opponent.pokemonActif].img);
    ctx.drawImage(document.getElementById('img-pokemon-opponent'), pokemonImgXOpponentAttacking, pokemonImgY);
  }

  if(dresseur.pokemonActif != 2){
    $('#img-pokemon-dresseur-3').attr('src', dresseur.team[2].img);
    ctx.drawImage(document.getElementById('img-pokemon-dresseur-3'), pokemonImgX-24, pokemonImgY+96+24);
    if(dresseur.team[2].hp == 0){
      ctx.drawImage(document.getElementById('img-pokemon-dresseur-3-dead'), pokemonImgX-24+spacingImgDeath, pokemonImgY+96+24+spacingImgDeath);
    }
  }
  if(opponent.pokemonActif != 2){
    $('#img-pokemon-opponent-3').attr('src', opponent.team[2].img);
    ctx.drawImage(document.getElementById('img-pokemon-opponent-3'), pokemonImgXOpponent+24, pokemonImgY+96+24);
    if(opponent.team[2].hp == 0){
      ctx.drawImage(document.getElementById('img-pokemon-opponent-3-dead'), pokemonImgXOpponent+24+spacingImgDeath, pokemonImgY+96+24+spacingImgDeath);
    }
  }

  if(dresseur.pokemonActif != 1){
    $('#img-pokemon-dresseur-2').attr('src', dresseur.team[1].img);
    ctx.drawImage(document.getElementById('img-pokemon-dresseur-2'), pokemonImgX+36, pokemonImgY+96);
    if(dresseur.team[1].hp == 0){
      ctx.drawImage(document.getElementById('img-pokemon-dresseur-2-dead'), pokemonImgX+36+spacingImgDeath, pokemonImgY+96+spacingImgDeath);
    }
  }
  if(opponent.pokemonActif != 1){
    $('#img-pokemon-opponent-2').attr('src', opponent.team[1].img);
    ctx.drawImage(document.getElementById('img-pokemon-opponent-2'), pokemonImgXOpponent-36, pokemonImgY+96);
    if(opponent.team[1].hp == 0){
      ctx.drawImage(document.getElementById('img-pokemon-opponent-2-dead'), pokemonImgXOpponent-36+spacingImgDeath, pokemonImgY+96+spacingImgDeath);
    }
  }

  if(dresseur.pokemonActif != 0){
    $('#img-pokemon-dresseur-1').attr('src', dresseur.team[0].img);
    ctx.drawImage(document.getElementById('img-pokemon-dresseur-1'), pokemonImgX+12, pokemonImgY+96+64);
    if(dresseur.team[0].hp == 0){
      ctx.drawImage(document.getElementById('img-pokemon-dresseur-1-dead'), pokemonImgX+12+spacingImgDeath, pokemonImgY+96+64+spacingImgDeath);
    }
  }
  if(opponent.pokemonActif != 0){
    $('#img-pokemon-opponent-1').attr('src', opponent.team[0].img);
    ctx.drawImage(document.getElementById('img-pokemon-opponent-1'), pokemonImgXOpponent-12, pokemonImgY+96+64);
    if(opponent.team[0].hp == 0){
      ctx.drawImage(document.getElementById('img-pokemon-opponent-1-dead'), pokemonImgXOpponent-12+spacingImgDeath, pokemonImgY+96+64+spacingImgDeath);
    }
  }
}


function attacking(isOpponent = false){
  if(move<20){
    if(!isOpponent){
      pokemonImgXAttacking = pokemonImgXAttacking + move;
    } else {
      pokemonImgXOpponentAttacking = pokemonImgXOpponentAttacking - move;
    }
    move++;
  }else{
    if(!isOpponent){
      pokemonImgXAttacking = pokemonImgX;
      dresseur.team[dresseur.pokemonActif].attacking = false;
    } else {
      pokemonImgXOpponentAttacking = pokemonImgXOpponent;
      opponent.team[opponent.pokemonActif].attacking = false;
    }
    move = 0;
  }
}

function drawResultBattle(){
  positionImgResultBattleX = 0;
  positionImgResultBattleY = 0;

  if(!isPlayerWinner){
    $('#img-result-battle').attr('src', '../Vue/assets/img/loose.png');
  }
  ctx.drawImage(document.getElementById('img-result-battle'), pokemonImgXAttacking, pokemonImgY);
}

function draw() {
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  if(isBattleStarted){
    drawDresseurName(dresseur.name);
    drawDresseurName(opponent.name, true);

    // Draws all pokemons
    drawPokemon();
    if(dresseur.pokemonActif != -1){
      drawPokemonInfo(dresseur.team[dresseur.pokemonActif]);
      if(dresseur.team[dresseur.pokemonActif].attacking){
        attacking();
      }
    }
    if(opponent.pokemonActif != -1){
      drawPokemonInfo(opponent.team[opponent.pokemonActif], true);
      if(opponent.team[opponent.pokemonActif].attacking){
        attacking(true);
      }
    }
  }

  if(isBattleEnded){
    drawResultBattle();
  }

  requestAnimationFrame(draw);
}

draw();
