<?php

namespace ID3Global\Identity\Documents;

use ID3Global\Identity\ID3IdentityObject;

class IdentityCard extends ID3IdentityObject
{
    /**
     * @var string
     */
    private $Number;

    /**
     * @var string
     */
    private $Country;

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->Number;
    }

    /**
     * @param string $Number
     * @return self
     */
    public function setNumber($Number)
    {
        $this->Number = $Number;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->Country;
    }

    /**
     * @param string $Country
     * @return self
     */
    public function setCountry($Country)
    {
        $this->Country = $Country;
        return $this;
    }
}