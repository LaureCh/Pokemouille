<?php
include('Controller/ApiRequest.php');
include('Controller/DBPower.php');
include('Model/Attack.php');
include('Model/Pokemon.php');

$db = new DBPower();
// go to find some datas on the chosen pokemon
$req = new ApiRequest();

$pokemonsNames = parse_ini_file('./config.ini', true)['POKEMONS']['pokemons'];

foreach ($pokemonsNames as $pokemonName) {
    $data = $req->getPokemon($pokemonName);
    // NEW POKEMON
    $pokemon = new Pokemon($pokemonName);

    //images url
    $pokemon->setFrontImageUrl($data['sprites']['front_shiny']);
    $pokemon->setBackImageUrl($data['sprites']['back_shiny']);
    $pokemon->setWeight($data['weight']);

    $urlPokemonFrenchNameAndEvolution = $data['species']['url'];
    $dataFrenchNamesAndEvolution = $req->getFrenchName($urlPokemonFrenchNameAndEvolution);

    //French name of the pokemon
    foreach ($dataFrenchNamesAndEvolution['names'] as $dataFrenchName) {
        if ($dataFrenchName['language']['name'] === 'fr') {
            $pokemon->setFrenchName($dataFrenchName['name']);
        }
    }
    //Evolution
    $urlEvolution = $dataFrenchNamesAndEvolution['evolution_chain']['url'];
    $evolution = $req->getEvolution($urlEvolution);

    //à améliorer, on nous retourne le nom et l'url, donc on pourrait get et reboucler.

    if (isset($evolution['chain']['evolves_to']['0']['evolves_to']['0']['species']['name'])){
        $pokemon->setEvolution($evolution['chain']['evolves_to']['0']['evolves_to']['0']['species']['name']);
    }
    //flush pokemon
    $idPokemon = $db->flushPokemon($pokemon);

    //pokemon's attacks
    foreach ($data['moves'] as $move) {
        if (array_key_exists('move', $move)) {
            $attacks[$move['move']['name']] = $move['move'] ['url'];
        }
    }
    $selectedMoves = array_rand($attacks, 3);

    //pour chaque attaque
    foreach ($selectedMoves as $selectedMove) {
        $urlAttack = $attacks[$selectedMove];

        $datattack = $req->getAttack($urlAttack);

        $attack = new Attack();

        while ($datattack['power'] == null || !is_int($datattack['accuracy'])){
            $newAttack = array_rand($attacks, 1);
            $urlNewAttack = $attacks[$newAttack];
            $datattack = $req->getAttack($urlNewAttack);
        }

        $attack->setDamages($datattack['power']);

        //get french name for an attack
        foreach ($datattack['names'] as $name) {
            if ($name['language']['name'] === 'fr') {
                $attack->setName($name['name']);
            }
        }
        //get french description for an attack
        foreach ($datattack['flavor_text_entries'] as $description) {
            if ($description['language']['name'] === 'fr') {
                $attack->setDescription($description['flavor_text']);
            }
        }

        $attack->setAccuracy($datattack['accuracy']);

        $idAttack = $db->flushAttack($attack);

        if ($idPokemon !== null && $idAttack !== null) {
            $db->joinPokemonAttack($idPokemon, $idAttack);
        }
        else {
            echo "Issue with IDPokemon:".$idPokemon." and IDattack:".$idAttack;
        }
    }

}
