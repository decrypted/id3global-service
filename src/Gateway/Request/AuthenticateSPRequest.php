<?php
namespace ID3Global\Gateway\Request;

use ID3Global\Identity\Address\Address;
use ID3Global\Identity\Identity;

class AuthenticateSPRequest
{
    /**
     * @var string
     */
    private $CustomerReference;

    /**
     * @var \stdClass
     */
    private $ProfileIDVersion;

    /**
     * @var \stdClass
     */
    private $InputData;

    public function addFieldsFromIdentity(Identity $identity)
    {
        $this->InputData = new \stdClass();

        $this->addPersonalDetails($identity);
        $this->addAddresses($identity);
        $this->addIdentityDocuments($identity);
        $this->addContactDetails($identity);

    }

    private function addPersonalDetails(Identity $identity)
    {
        $this->InputData->Personal = new \stdClass();
        $personalDetails = $identity->getPersonalDetails();

        if (is_a($personalDetails, '\ID3Global\Identity\PersonalDetails')) {
            $this->InputData->Personal->PersonalDetails = $personalDetails;
        }
    }

    private function addContactDetails(Identity $identity)
    {
        $contactDetails = $identity->getContactDetails();
        if (is_a($contactDetails, '\ID3Global\Identity\ContactDetails')) {
            $this->InputData->ContactDetails = $contactDetails;
        }
    }

    private function addAddresses(Identity $identity)
    {
        $this->InputData->Addresses = new \stdClass();
        $addresses = $identity->getAddresses();

        if (is_a($addresses, '\ID3Global\Identity\Address\AddressContainer')) {
            $currentAddress = $addresses->getCurrentAddress();

            if ($currentAddress instanceof Address) {
                $this->InputData->Addresses->CurrentAddress = $currentAddress;
            }
        }
    }

    private function addIdentityDocuments(Identity $identity)
    {
        $this->InputData->IdentityDocuments = new \stdClass();
        $documents = $identity->getIdentityDocuments();

        if(is_a($documents, '\ID3Global\Identity\Documents\DocumentContainer')) {
            $passport = $documents->getInternationalPassport();

            if(is_a($passport, '\ID3Global\Identity\Documents\InternationalPassport')) {
                $this->InputData->IdentityDocuments->InternationalPassport = $passport;
            }
            $identityCard = $documents->getIdentityCard();

            if(is_a($identityCard, '\ID3Global\Identity\Documents\IdentityCard')) {
                $this->InputData->IdentityDocuments->IdentityCard = $identityCard;
            }

            foreach($documents->getValidCountries() as $country) {
                $varName = sprintf('get%sDocuments', $country);
                $countryDocuments = $documents->$varName();

                if(is_object($countryDocuments)) {
                    $this->InputData->IdentityDocuments->$country = $countryDocuments;
                }
            }
        }
    }

    /**
     * @return string
     */
    public function getCustomerReference()
    {
        return $this->CustomerReference;
    }

    /**
     * @param string $CustomerReference
     * @return AuthenticateSPRequest
     */
    public function setCustomerReference($CustomerReference)
    {
        $this->CustomerReference = $CustomerReference;
        return $this;
    }

    /**
     * @return \stdClass
     */
    public function getProfileIDVersion()
    {
        return $this->ProfileIDVersion;
    }

    /**
     * @param \stdClass $ProfileIDVersion
     * @return AuthenticateSPRequest
     */
    public function setProfileIDVersion($ProfileIDVersion)
    {
        $this->ProfileIDVersion = $ProfileIDVersion;
        return $this;
    }

    public function getInputData()
    {
        return $this->InputData;
    }
}
