<?php

/**
 * Class Pokemon
 */
class Pokemon
{
    private $frenchName;
    private $englishName;
    private $evolution;
    private $attacks;
    private $lifeMax;
    private $backImageUrl;
    private $frontImageUrl;
    private $weight;

    /**
     * Pokemon constructor.
     * @param $englishName
     */
    public function __construct($englishName)
    {
        $this->englishName = $englishName;
        $this->attacks= [];
        $this->lifeMax = rand(50, 100);
    }

    /**
     * @return mixed
     */
    public function getFrenchName()
    {
        return $this->frenchName;
    }

    /**
     * @param mixed $frenchName
     * @return Pokemon
     */
    public function setFrenchName($frenchName)
    {
        $this->frenchName = $frenchName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEnglishName()
    {
        return $this->englishName;
    }

    /**
     * @param mixed $englishName
     * @return Pokemon
     */
    public function setEnglishName($englishName)
    {
        $this->englishName = $englishName;
        return $this;
    }

    /**
     * @return String
     */
    public function getEvolution() : ?String
    {
        return $this->evolution;
    }

    /**
     * @param String $evolution
     */
    public function setEvolution(String $evolution)
    {
        $this->evolution = $evolution;
    }

    /**
     * @return array
     */
    public function getAttacks() : array
    {
        return $this->attacks;
    }

    /**
     * @param Attack $attack
     */
    public function setAttacks(Attack $attack): void
    {
        $this->attacks[] = $attack;
    }

    /**
     * @return int
     */
    public function getLifeMax() :int
    {
        return $this->lifeMax;
    }

    /**
     * @param int $lifeMax
     * @return Pokemon
     */
    public function setLifeMax(int $lifeMax) : Pokemon
    {
        $this->lifeMax = $lifeMax;
        return $this;
    }

    /**
     * @return String
     */
    public function getBackImageUrl()
    {
        return $this->backImageUrl;
    }

    /**
     * @param String $backImageUrl
     * @return Pokemon
     */
    public function setBackImageUrl($backImageUrl)
    {
        $this->backImageUrl = $backImageUrl;
        return $this;
    }

    /**
     * @return String
     */
    public function getFrontImageUrl() : String
    {
        return $this->frontImageUrl;
    }

    /**
     * @param String $frontImageUrl
     * @return Pokemon
     */
    public function setFrontImageUrl($frontImageUrl) : Pokemon
    {
        $this->frontImageUrl = $frontImageUrl;
        return $this;
    }

    /**
     * @return int
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param int $weight
     * @return Pokemon
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
        return $this;
    }

}
