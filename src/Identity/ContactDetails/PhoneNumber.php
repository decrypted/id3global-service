<?php
namespace ID3Global\Identity\ContactDetails;

class PhoneNumber {
    /**
     * @var string
     */
    private $Number;

    /**
     * @param string $number
     * @return PhoneNumber
     */
    public function setNumber($number) {
        $this->Number = $number;
        return $this;
    }
}
