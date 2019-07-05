<?php
namespace ID3Global\Identity;

use ID3Global\Identity\Canada\SocialInsuranceNumber;

class Canada {
    /**
     * @var SocialInsuranceNumber
     */
    private $SocialInsuranceNumber;
    
    /**
     * @param SocialInsuranceNumber $socialInsuranceNumber
     * @return Canada
     */
    public function setSocialInsuranceNumber($socialInsuranceNumber)
    {
        $this->SocialInsuranceNumber = $socialInsuranceNumber;
        return $this;
    }
    
    /**
     * @return SocialInsuranceNumber
     */
    public function getSocialInsuranceNumber()
    {
        return $this->SocialInsuranceNumber;
    }
}
