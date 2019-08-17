<?php

/**
 * Class Attack
 */
class Attack
{
    public $name;
    public $damages;
    public $accuracy;
    public $description;

    /**
     * @return String
     */
    public function getName(): String
    {
        return $this->name;
    }

    /**
     * @param String $name
     * @return Attack
     */
    public function setName(String $name): Attack
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getDamages(): int
    {
        return $this->damages;
    }

    /**
     * @param int $damages
     * @return Attack
     */
    public function setDamages(int $damages): Attack
    {
        $this->damages = $damages;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAccuracy()
    {
        return $this->accuracy;
    }

    /**
     * @param mixed $accuracy
     * @return Attack
     */
    public function setAccuracy($accuracy)
    {
        $this->accuracy = $accuracy;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return Attack
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
}