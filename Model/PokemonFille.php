<?php
include('Dresseur.php');
include('Pokemon.php');

class PokemonFille
{
    public Dresseur $dresseur;
    public Pokemon $pokemon;
    public int $xp;
    public int $life;

    public function __construct(Dresseur $dresseur, Pokemon $pokemon)
    {
        $this->dresseur = $dresseur;
        $this->pokemon = $pokemon;
        $this->xp = 0;
        $this->life = $pokemon->getLifeMax();
    }

    /**
     * @return Dresseur
     */
    public function getDresseur(): Dresseur
    {
        return $this->dresseur;
    }

    /**
     * @param Dresseur $dresseur
     * @return PokemonFille
     */
    public function setDresseur(Dresseur $dresseur): PokemonFille
    {
        $this->dresseur = $dresseur;
        return $this;
    }

    /**
     * @return Pokemon
     */
    public function getPokemon(): Pokemon
    {
        return $this->pokemon;
    }

    /**
     * @param Pokemon $pokemon
     * @return PokemonFille
     */
    public function setPokemon(Pokemon $pokemon): PokemonFille
    {
        $this->pokemon = $pokemon;
        return $this;
    }

    /**
     * @return int
     */
    public function getXp(): int
    {
        return $this->xp;
    }

    /**
     * @param int $xp
     * @return PokemonFille
     */
    public function setXp(int $xp): PokemonFille
    {
        $this->xp = $xp;
        return $this;
    }

    /**
     * @return int
     */
    public function getLife() : int
    {
        return $this->life;
    }

    /**
     * @param mixed $life
     * @return PokemonFille
     */
    public function setLife($life) :PokemonFille
    {
        $this->life = $life;
        return $this;
    }


}