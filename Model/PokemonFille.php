<?php

class PokemonFille
{
    public $id;
    public $dresseur;
    public $pokemon;
    public $xp;
    public $idPokemon;

    public function __construct()
    {
    }

    /**
     * @return Dresseur
     */
    public function getDresseur()
    {
        return $this->dresseur;
    }

    /**
     * @param Dresseur $dresseur
     * @return PokemonFille
     */
    public function setDresseur(Dresseur $dresseur)
    {
        $this->dresseur = $dresseur;
    }

    /**
     * @return Pokemon
     */
    public function getPokemon()
    {
        return $this->pokemon;
    }

    /**
     * @param Pokemon $pokemon
     * @return PokemonFille
     */
    public function setPokemon(Pokemon $pokemon)
    {
        $this->pokemon = $pokemon;
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
    public function setXp(int $xp)
    {
        $this->xp = $xp;
    }

    /**
     * @return int
     */
    public function getIdPokemon() : int
    {
        return $this->idPokemon;
    }

    /**
     * @param mixed $idPokemon
     */
    public function setIdPokemon($idPokemon)
    {
        $this->idPokemon = $idPokemon;
    }

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


}
