var canvas = document.getElementById("fight");
var ctx = canvas.getContext("2d");

// init data
var dresseur = {};
var opponent = {};
dresseur.pokemon = [
  new Pokemon(1, "Pikachu", 200, 25),
  new Pokemon(6, "Salamèche", 240, 7),
  new Pokemon(5, "Tortank", 400, 6),
];
opponent.pokemon = [
  new Pokemon(2, "Raichu", 320, 25),
  new Pokemon(13, "Caninos", 280, 7),
  new Pokemon(8, "Dracaufeu", 400, 6),
];

// Battle info
var isBattleStarted = false;
dresseur.pokemonActif = 0;
opponent.pokemonActif = 0;

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
}

function drawPokemon(){
  // Draw
  ctx.drawImage(document.getElementById('img-pokemon-dresseur'), pokemonImgXAttacking, pokemonImgY);
  ctx.drawImage(document.getElementById('img-pokemon-opponent'), pokemonImgXOpponentAttacking, pokemonImgY);
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
      dresseur.pokemon[dresseur.pokemonActif].attacking = false;
    } else {
      pokemonImgXOpponentAttacking = pokemonImgXOpponent;
      opponent.pokemon[opponent.pokemonActif].attacking = false;
    }
    move = 0;
  }
}

function draw() {
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  if(isBattleStarted){
    drawPokemonInfo(dresseur.pokemon[dresseur.pokemonActif]);
    drawPokemonInfo(opponent.pokemon[opponent.pokemonActif], true);
    drawPokemon();

    if(dresseur.pokemon[dresseur.pokemonActif].attacking){
      attacking();
    }
    if(opponent.pokemon[opponent.pokemonActif].attacking){
      attacking(true);
    }
  }

  requestAnimationFrame(draw);
}


draw();
