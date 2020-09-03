<?php
namespace ID3Global\Identity\Documents\IN;

use ID3Global\Identity\ID3IdentityObject;

class PAN extends ID3IdentityObject
{
    /**
     * @var string The Voter ID number
     */
    private $Number;

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
}
