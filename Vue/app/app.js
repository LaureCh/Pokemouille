var canvas = document.getElementById("fight");
var ctx = canvas.getContext("2d");

var isBattleStarted = false;

// init data
var pokemon1 = new Pokemon(25, "Pikachu", 400, 25);
var pokemon2 = new Pokemon(4, "Salamèche", 300, 4);

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

function drawPokemonInfo(pokemon, opponent = false) {
  // Position
  var barPositionX = barHealtOffset;
  var barPositionY = barHealtOffset+20;
  if(opponent){
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
}

function drawPokemon(){
  // Draw
  ctx.drawImage(document.getElementById('pokemon1'), pokemonImgXAttacking, pokemonImgY);
  ctx.drawImage(document.getElementById('pokemon2'), pokemonImgXOpponentAttacking, pokemonImgY);
}


function attacking(opponent = false){
  if(move<20){
    if(!opponent){
      pokemonImgXAttacking = pokemonImgXAttacking + move;
    } else {
      pokemonImgXOpponentAttacking = pokemonImgXOpponentAttacking - move;
    }
    move++;
  }else{
    if(!opponent){
      pokemonImgXAttacking = pokemonImgX;
      pokemon1.attacking = false;
    } else {
      pokemonImgXOpponentAttacking = pokemonImgXOpponent;
      pokemon2.attacking = false;
    }
    move = 0;
  }
}

function draw() {
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  if(isBattleStarted){
    drawPokemonInfo(pokemon1);
    drawPokemonInfo(pokemon2, true);
      drawPokemon();

    if(pokemon1.attacking){
      attacking();
    }
    if(pokemon2.attacking){
      attacking(true);
    }
  }

  requestAnimationFrame(draw);
}


draw();
