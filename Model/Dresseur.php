<?php

/**
 * Class Dresseur
 */
class Dresseur
{
    public $username;
    public $password;
    private $pokemons;

    /**
     * Dresseur constructor.
     */
    public function __construct(String $username)
    {
        $this->username = $username;
    }

    /**
     * @return String
     */
    public function getUsername() : String
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     */
    public function setPokemons(array $pokemons): void
    {
        $this->pokemons = $pokemons;
    }

    /**
     */
    public function addPokemon(Pokemon $pokemon): void
    {
        $this->pokemon[] = $pokemon;
    }

    /**
     * @return array
     */
    public function getPokemons() : array
    {
        return $this->pokemons;
    }
}
?>
