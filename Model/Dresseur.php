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
     * @param Pokemon $pokemon
     */
    public function setPokemons(Pokemon $pokemon): void
    {
        $this->pokemons[] = $pokemon;
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