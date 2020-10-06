<?php
namespace ID3Global\Identity\Documents\CN;

use ID3Global\Identity\ID3IdentityObject;

class ResidentIdentityCard extends ID3IdentityObject
{
    /**
     * @var string The driver licence identifier
     */
    private $Number;

    public function getNumber() {
        return $this->Number;
    }

    /**
     * @param string $Number
     * @return ResidentIdentityCard
     */
    public function setNumber($Number)
    {
        $this->Number = $Number;
        return $this;
    }
}
