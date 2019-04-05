<?php
namespace ID3Global\Identity\Documents\US;

use ID3Global\Identity\ID3IdentityObject;

class DrivingLicence extends ID3IdentityObject
{
    /**
     * @var string The driver licence identifier
     */
    private $Number;

    /**
     * @var string State code
     */
    private $State;

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
     * @return int
     */
    public function getState()
    {
        return $this->State;
    }

    /**
     * @param int $State
     * @return self
     */
    public function setState($State)
    {
        $this->State = $State;
        return $this;
    }
}
