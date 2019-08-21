var canvas = document.getElementById("fight");
var ctx = canvas.getContext("2d");

// init data
var dresseur = new Dresseur();
var opponent = new Dresseur();

// Battle info
var isBattleStarted = false;

// Bar health
var barHealtwidth = 100;
var barHealtheight = 15;
var barHealtOffset = 10;

// Pokemon img position
var pokemonImgX = 15;
var pokemonImgXOpponent = canvas.width-96-15;
var pokemonImgY = 60;
var pokemonImgXAttacking = pokemonImgX;
var pokemonImgXOpponentAttacking = pokemonImgXOpponent;

var move = 0;

function drawPokemonInfo(pokemon, isOpponent = false) {
  // Position
  var barPositionX = barHealtOffset;
  var barPositionY = barHealtOffset+20;
  if(isOpponent){
    var barPositionX = canvas.width-barHealtOffset-barHealtwidth;
  }

  // Pokemon name
  ctx.font = "16px Arial";
  ctx.fillStyle = "#0095DD";
  ctx.fillText(pokemon.name, barPositionX-8, 20);

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

  ctx.font = "14px Arial";
  ctx.fillStyle = "#0095DD";
  ctx.fillText(pokemon.hp+' / '+pokemon.hpMax, barPositionX-8, 60);
}

function drawPokemon(){
  // Draw
  $('#img-pokemon-dresseur').attr('src', dresseur.team[dresseur.pokemonActif].img);
  $('#img-pokemon-opponent').attr('src', opponent.team[opponent.pokemonActif].img);
  ctx.drawImage(document.getElementById('img-pokemon-dresseur'), pokemonImgXAttacking, pokemonImgY);
  ctx.drawImage(document.getElementById('img-pokemon-opponent'), pokemonImgXOpponentAttacking, pokemonImgY);

  if(dresseur.pokemonActif != 2){
    $('#img-pokemon-dresseur-3').attr('src', dresseur.team[2].img);
    ctx.drawImage(document.getElementById('img-pokemon-dresseur-3'), pokemonImgX-24, pokemonImgY+96+24);
  }
  if(opponent.pokemonActif != 2){
    $('#img-pokemon-opponent-3').attr('src', opponent.team[2].img);
    ctx.drawImage(document.getElementById('img-pokemon-opponent-3'), pokemonImgXOpponent+24, pokemonImgY+96+24);
  }

  if(dresseur.pokemonActif != 1){
    $('#img-pokemon-dresseur-2').attr('src', dresseur.team[1].img);
    ctx.drawImage(document.getElementById('img-pokemon-dresseur-2'), pokemonImgX+36, pokemonImgY+96);
  }
  if(opponent.pokemonActif != 1){
    $('#img-pokemon-opponent-2').attr('src', opponent.team[1].img);
    ctx.drawImage(document.getElementById('img-pokemon-opponent-2'), pokemonImgXOpponent-36, pokemonImgY+96);
  }

  if(dresseur.pokemonActif != 0){
    $('#img-pokemon-dresseur-1').attr('src', dresseur.team[0].img);
    ctx.drawImage(document.getElementById('img-pokemon-dresseur-1'), pokemonImgX+12, pokemonImgY+96+64);
  }
  if(opponent.pokemonActif != 0){
    $('#img-pokemon-opponent-1').attr('src', opponent.team[0].img);
    ctx.drawImage(document.getElementById('img-pokemon-opponent-1'), pokemonImgXOpponent-12, pokemonImgY+96+64);
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

function draw() {
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  if(isBattleStarted){
    drawPokemonInfo(dresseur.team[dresseur.pokemonActif]);
    drawPokemonInfo(opponent.team[opponent.pokemonActif], true);
    drawPokemon();

    if(dresseur.team[dresseur.pokemonActif].attacking){
      attacking();
    }
    if(opponent.team[opponent.pokemonActif].attacking){
      attacking(true);
    }
  }

  requestAnimationFrame(draw);
}

draw();
