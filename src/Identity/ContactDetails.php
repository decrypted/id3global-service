<?php
namespace ID3Global\Identity;

use ID3Global\Identity\ContactDetails\PhoneNumber;

class ContactDetails {
    /**
     * @var PhoneNumber
     */
    private $LandTelephone;

    /**
     * @var PhoneNumber
     */
    private $MobileTelephone;

    /**
     * @var PhoneNumber
     */
    private $WorkTelephone;

    /**
     * @var string
     */
    private $Email;

    /**
     * @param PhoneNumber $landPhone
     * @return ContactDetails
     */
    public function setLandTelephone(PhoneNumber $landPhone)
    {
        $this->LandTelephone = $landPhone;
        return $this;
    }

    /**
     * @param PhoneNumber $mobilePhone
     * @return ContactDetails
     */
    public function setMobileTelephone(PhoneNumber $mobilePhone)
    {
        $this->MobileTelephone = $mobilePhone;
        return $this;
    }

    /**
     * @param PhoneNumber $workPhone
     * @return ContactDetails
     */
    public function setWorkTelephone(PhoneNumber $workPhone)
    {
        $this->WorkTelephone = $workPhone;
        return $this;
    }

    /**
     * @param string $email
     * @return ContactDetails
     */
    public function setEmail($email)
    {
        $this->Email = $email;
        return $this;
    }
}
