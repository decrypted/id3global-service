<?php
namespace ID3Global\Identity\Documents;

use ID3Global\Identity\ID3IdentityObject;

class DocumentContainer extends ID3IdentityObject
{
    /**
     * @var InternationalPassport
     */
    private $InternationalPassport;

    /**
     * @var IdentityCard
     */
    private $IdentityCard;

    /**
     * @var \stdClass Identity documents relevant to New Zealand
     */
    private $NewZealand = null;

    /**
     * @var \stdClass Identity documents relevant to Brazi
     */
    private $Brazil = null;

    /**
     * @var \stdClass Identity documents relevant to US
     */
    private $US = null;

    /**
     * @var \stdClass Identity documents relevant to Mexico
     */
    private $Mexico = null;

    /**
     * @var \stdClass Identity documents relevant to India
     */
    private $India = null;

    /**
     * @var \stdClass Identity documents relevant to Canada
     */
    private $Canada = null;

    /**
     * @var array Used by self::addIdentityDocument() to ensure the country name is valid
     */
    private $validCountries = array(
        'NewZealand',
        'Brazil',
        'US',
        'Mexico',
        'India',
        'Canada',
    );

    /**
     * @return InternationalPassport
     */
    public function getInternationalPassport()
    {
        return $this->InternationalPassport;
    }

    /**
     * @param InternationalPassport $InternationalPassport
     * @return DocumentContainer
     */
    public function setInternationalPassport($InternationalPassport)
    {
        $this->InternationalPassport = $InternationalPassport;
        return $this;
    }

    /**
     * @return IdentityCard
     */
    public function getIdentityCard() {
        return $this->IdentityCard;
    }

    /**
     * @param IdentityCard $IdentityCard
     * @return DocumentContainer
     */
    public function setIdentityCard($IdentityCard) {
        $this->IdentityCard = $IdentityCard;
        return $this;
    }

    /**
     * @return \stdClass
     */
    public function getNewZealandDocuments()
    {
        return $this->NewZealand;
    }

    /**
     * @return \stdClass
     */
    public function getBrazilDocuments()
    {
        return $this->Brazil;
    }

    /**
     * @return \stdClass
     */
    public function getUSDocuments()
    {
        return $this->US;
    }

    /**
     * @return \stdClass
     */
    public function getMexicoDocuments()
    {
        return $this->Mexico;
    }

    /**
     * @return \stdClass
     */
    public function getIndiaDocuments()
    {
        return $this->India;
    }

    /**
     * @return \stdClass
     */
    public function getCanadaDocuments()
    {
        return $this->Canada;
    }

    /**
     * @param ID3IdentityObject $document
     * @param string $country The country to assign this document to (e.g. 'New Zealand')
     * @return DocumentContainer
     */
    public function addIdentityDocument(ID3IdentityObject $document, $country)
    {
        //
        $varName = preg_replace('/[^A-Za-z]*/', '', $country);
        $r = new \ReflectionClass($document);
        $docType = $r->getShortName();

        if(in_array($varName, $this->validCountries)) {
            if(is_null($this->$varName)) {
                $this->$varName = new \stdClass();
            }

            $this->$varName->$docType = $document;
        } else {
            throw new \InvalidArgumentException(sprintf('An invalid country "%s" was passed.', $country));
        }

        return $this;
    }

    public function getValidCountries() {
        return $this->validCountries;
    }
}
