<?php

class DBPower
{
    private $config;
    private $bdd;

    public function __construct()
    {
        $this->config = parse_ini_file('../config.ini', true)['DB'];
        $this->bdd = $this->connect();
    }

    public function connect()
    {        try {
           return new PDO('mysql:dbname=' . $this->config['name'] . ';host=' . $this->config['host'],
                $this->config['user'],
                $this->config['password'],
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
            );
        } catch (PDOException $e) {
            echo 'Connexion failed : ' . $e->getMessage();
        }
        $this->bdd->query("SET NAMES UTF8");//Solution encodage UTF8

    }

    public function getPokemons()
    {
      $sql = "SELECT * FROM pokemon ORDER BY id_pokemon asc";

      $response = $this->bdd->query($sql);

      return ($response->fetchAll());
    }

    public function getAttacks()
    {
      $sql = "SELECT * FROM attack ORDER BY id_attack asc";

      $response = $this->bdd->query($sql);

      return ($response->fetchAll());
    }

    public function getPokemonsByIds(array $pokemonsIds)
    {
      $pokemonsIds = implode(',', array_values($pokemonsIds));

      $sql = "SELECT * FROM pokemon WHERE id_pokemon IN (".$pokemonsIds.")";

      $response = $this->bdd->query($sql);

      return ($response->fetchAll());
    }

    public function flushAttack(Attack $attack)
    {
        try{
            $sql = "INSERT INTO Attack(damage, name, description, accuracy)
                    VALUES
                    ('".$attack->getDamages()."','".$attack->getName()."','".$attack->getDescription()."','".$attack->getAccuracy()."')";

            $this->bdd->query($sql);
        }
        catch (Exception $e)
        {
            echo "Error". $e->getMessage()." name:".$attack->getName()." damage:".$attack->getDamages()." damage:".$attack->getAccuracy();
        }
        $sqlGet = "SELECT id_attack FROM Attack WHERE name = '".$attack->getName()."'";
        $response = $this->bdd->query($sqlGet);
        return ($response->fetch()['id_attack']);
    }

    public function flushPokemon(Pokemon $pokemon)
    {
        $sql = "INSERT INTO Pokemon(french_name, english_name,life_max,back_image_url,front_image_url, evolution)
                    VALUES
                    ('".$pokemon->getFrenchName()."','".$pokemon->getEnglishName()."','".$pokemon->getLifeMax()."','".$pokemon->getBackImageUrl()."','".$pokemon->getFrontImageUrl()."','".$pokemon->getEvolution()."')";

        $this->bdd->query($sql);

        $sqlGet = "SELECT id_pokemon FROM Pokemon WHERE french_name = '".$pokemon->getFrenchName()."'";
        $response = $this->bdd->query($sqlGet);
        return ($response->fetch()['id_pokemon']);
    }

    public function joinPokemonAttack($pokemonId, $attackId) {
        try{
            $sql = "INSERT INTO join_pokemon_attack(fk_id_pokemon, fk_id_attack)
                    VALUES
                        ('".$pokemonId."','".$attackId."')";

            $this->bdd->query($sql);
        }
        catch(Exception $e){
            echo "Error:".$e->getMessage()." PokemonId:".$pokemonId." AttackId:".$attackId;
        }
    }

    public function getPokemonsDresseur($username)
    {
      $sql = "SELECT p.id_pokemon, pf.xp, pf.id_pokemon_fille FROM dresseur d, pokemon_fille pf, pokemon p
              WHERE d.id_dresseur = pf.fk_id_dresseur
              AND pf.fk_id_pokemon = p.id_pokemon
              AND d.username ='".$username."'";
      $response = $this->bdd->query($sql);

      return ($response->fetchAll());

    }

    public function getAttacksFromPokemon($pokemonId)
    {
      $sql = "SELECT a.* FROM join_pokemon_attack pa, attack a
              WHERE pa.fk_id_attack = a.id_attack
              AND pa.fk_id_pokemon ='".$pokemonId."'";
      $response = $this->bdd->query($sql);

      return ($response->fetchAll());

    }

    public function updateXp($pokemons){
      foreach ($pokemons as $p) {
        try{
            $sql = "UPDATE `pokemon_fille` SET `xp` = '".$p['xp']."' WHERE `pokemon_fille`.`id_pokemon_fille` = ".$p['id'];

            $this->bdd->query($sql);
        }
        catch(Exception $e){
            echo "Error:".$e->getMessage()." PokemonFilleId:".$p['id']." Xp:".$p['xp'];
        }
      }

    }

    public function createDresseur($name, $pokemonsIds){
      // create dresseur
      $sql = "INSERT INTO Dresseur(username) VALUES('".$name."')";
      $this->bdd->query($sql);

      $sql = "SELECT LAST_INSERT_ID()";
      $lastInsertId = $this->bdd->query($sql)->fetch()['LAST_INSERT_ID()'];

      // create dresseur's pokemons
      foreach ($pokemonsIds as $id){
        $sql = "INSERT INTO Pokemon_fille(fk_id_pokemon, fk_id_dresseur) VALUES('".$id."', '".$lastInsertId."')";
        $this->bdd->query($sql);
      }

      return $lastInsertId;
    }
}
?>
