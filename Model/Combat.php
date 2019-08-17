<?php

include('PokemonFille.php');
include('Attack.php');

/**
 * Class Combat
 */
class Combat
{
    public PokemonFille $pokemon1;
    public PokemonFille $pokemon2;
    public Attack $attack;
    public PokemonFille $active;

    /**
     * Combat constructor.
     * @param PokemonFille $pokemon1
     * @param PokemonFille $pokemon2
     */
    public function __construct(PokemonFille $pokemon1, PokemonFille $pokemon2)
    {
        $this->pokemon1 = $pokemon1;
        $this->pokemon2 = $pokemon2;
        $this->active = $pokemon1;
    }

    /**
     * @return PokemonFille
     */
    public function getPokemon1(): PokemonFille
    {
        return $this->pokemon1;
    }

    /**
     * @param PokemonFille $pokemon1
     * @return Combat
     */
    public function setPokemon1(PokemonFille $pokemon1) : Combat
    {
        $this->pokemon1 = $pokemon1;
        return $this;
    }

    /**
     * @return PokemonFille
     */
    public function getPokemon2() : PokemonFille
    {
        return $this->pokemon2;
    }

    /**
     * @param PokemonFille $pokemon2
     * @return Combat
     */
    public function setPokemon2(PokemonFille $pokemon2) : Combat
    {
        $this->pokemon2 = $pokemon2;
        return $this;
    }

    /**
     * @return Attack
     */
    public function getAttack(): Attack
    {
        return $this->attack;
    }

    /**
     * @param Attack $attack
     * @return Combat
     */
    public function setAttack($attack): Combat
    {
        $this->attack = $attack;
        return $this;
    }

    /**
     * @return PokemonFille
     */
    public function getActive() : PokemonFille
    {
        return $this->active;
    }

    /**
     * @param PokemonFille $pokemon
     * @return Combat
     */
    public function setActive(PokemonFille $pokemon): Combat
    {
        $this->active = $pokemon;
        return $this;
    }

    /**
     *
     */
    public function hit()
    {
        /* PokemonFille $puncheur */
        $puncheur = $this->active;

        /* PokemonFille $victim */
        $victim = ($puncheur == $this->pokemon1) ? $this->pokemon1 : $this->pokemon2;

        $damages = $this->attack->getDamages();

        $victim->setLife($victim->getLife() - $damages);



     // Check if die, if it is muerto, xp to the puncheur, else hit suivant

    }

}
