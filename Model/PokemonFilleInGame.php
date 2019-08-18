<?php

class PokemonFilleInGame extends PokemonFille
{
    public $name;
    public $hp;
    public $img;

    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getHp() : int
    {
        return $this->hp;
    }

    /**
     * @param int $hp
     */
    public function setHp(int $hp)
    {
        $this->hp = $hp;
    }

    /**
     * @return string
     */
    public function getImg() : string
    {
        return $this->img;
    }

    /**
     * @param string $img
     */
    public function setImg(string $img)
    {
        $this->img = $img;
    }
}
