<?php
$config = parse_ini_file('config.ini');

try {
    $bdd = new PDO('mysql:dbname='.$config['name'].';host='.$config['host'],
                    $config['user'],
                    $config['password'],
                    array(PDO::ATTR_ERRMODE=> PDO::ERRMODE_EXCEPTION)
    );
} catch (PDOException $e) {
    echo 'Connexion failed : ' . $e->getMessage();
}

$createTables['createTableDresseur'] =
    'CREATE TABLE dresseur
        (
            id_dresseur INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
            username VARCHAR(20),
            password VARCHAR (20)
        )  ENGINE=InnoDB DEFAULT CHARSET=utf8;';

$createTables['createTablePokemon'] =
    'CREATE TABLE pokemon
        (
            id_pokemon INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
            french_name VARCHAR(25),
            english_name VARCHAR(25),
            life_max INT,
            back_image_url VARCHAR(100),
            front_image_url VARCHAR(100),
            evolution VARCHAR(25) 
            
/*    à voir dans un second temps
        CONSTRAINT fk_evolution_id
                FOREIGN KEY (fk_id_evolution)
                REFERENCES pokemon(id_pokemon) */
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;';

$createTables['createTablePokemonFille'] =
    'CREATE TABLE pokemon_fille
        (
            id_pokemon_fille INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
            fk_id_pokemon INT,
            fk_id_dresseur INT,
            life INT,
            xp INT,
            CONSTRAINT fk_id_pokemon
                FOREIGN KEY (fk_id_pokemon)
                REFERENCES pokemon(id_pokemon),
            CONSTRAINT fk_id_dresseur
                FOREIGN KEY (fk_id_dresseur)
                REFERENCES dresseur(id_dresseur)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;';

$createTables['createTableAttack'] =
    'CREATE TABLE attack
        (
            id_attack INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
            name VARCHAR(25),
            damage INT,
            description VARCHAR(500),
            accuracy INT
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;';

$createTables['createJoinTablePokemonAttack'] =
    'CREATE TABLE join_pokemon_attack
        (
            fk_id_pokemon INT,
            fk_id_attack INT,
            CONSTRAINT fk_pokemon_id
                FOREIGN KEY (fk_id_pokemon)
                REFERENCES pokemon(id_pokemon),
            CONSTRAINT fk_attack_id
                FOREIGN KEY (fk_id_attack)
                REFERENCES attack(id_attack)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;';

$createTables['createTableCombat'] =
    'CREATE TABLE combat
        (
            id_combat INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
            fk_id_pokemon1 INT, 
            fk_id_pokemon2 INT,
            fk_id_attack INT,
            actif INT,
            CONSTRAINT fk_pokemon1_id
                FOREIGN KEY (fk_id_pokemon1)
                REFERENCES pokemon(id_pokemon),
            CONSTRAINT fk_pokemon2_id
                FOREIGN KEY (fk_id_pokemon2)
                REFERENCES pokemon(id_pokemon),
            CONSTRAINT fk_id_attaque
                FOREIGN KEY (fk_id_attack)
                REFERENCES attack(id_attack)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;';


foreach ($createTables as $createTable){
    try {
        $response = $bdd->query($createTable);
    } catch (PDOException $e) {
        echo 'Request issue : ' . $e->getMessage();
    }
}

 $response->closeCursor();

?>
