<?php

class DBPower
{
    private $config;
    private $bdd;

    public function __construct()
    {
        $this->config = parse_ini_file('./config.ini', true)['DB'];
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
}
?>

