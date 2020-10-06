<?php
namespace ID3Global\Tests\Gateway\Request;

use ID3Global\Gateway\Request\AuthenticateSPRequest,
    ID3Global\Identity\Address\FixedFormatAddress,
    ID3Global\Identity\Address\FreeFormatAddress,
    ID3Global\Identity\Address\AddressContainer,
    ID3Global\Identity\Identity,
    ID3Global\Identity\Documents\DocumentContainer,
    ID3Global\Identity\Documents\NZ\DrivingLicence,
    ID3Global\Identity\Documents\CN\ResidentIdentityCard,
    ID3Global\Identity\Documents\CA\SocialInsuranceNumber,
    ID3Global\Identity\Documents\IN\Epic,
    ID3Global\Identity\Documents\IN\PAN,
    \ID3Global\Identity\Documents\IN\DrivingLicence as InDrivingLicence;

class AuthenticateSPRequestTest extends \PHPUnit\Framework\TestCase {
    /**
     * @covers \ID3Global\Gateway\Request\AuthenticateSPRequest
     */
    public function testStandardParams() {
        $version = new \stdClass();
        $version->Version = 1;
        $version->ID = 'abc123-x';
        $r = new AuthenticateSPRequest();

        $r->setCustomerReference('X')->setProfileIDVersion($version);

        $this->assertEquals(1, $r->getProfileIDVersion()->Version);
        $this->assertEquals('abc123-x', $r->getProfileIDVersion()->ID);
        $this->assertEquals('X', $r->getCustomerReference());
    }

    /**
     * @covers \ID3Global\Identity\Address\FixedFormatAddress
     */
    public function testFixedLengthAddress() {
        $identity = new Identity();
        $container = new AddressContainer();
        $address = new FixedFormatAddress();
        $address
            ->setPrincipality('US')
            ->setCountry('US')
            ->setStateDistrict('NY')
            ->setRegion('New York')
            ->setCity('New York')
            ->setSubCity('Manhattan')
            ->setStreet('5th Ave')
            ->setSubStreet('5th Ave')
            ->setBuilding('350')
            ->setSubBuilding('350')
            ->setPremise('Empire State Building')
            ->setZipPostcode('10118');

        $container->setCurrentAddress($address);
        $identity->setAddresses($container);

        $r = new AuthenticateSPRequest();
        $r->addFieldsFromIdentity($identity);
        $test = $r->getInputData()->Addresses->CurrentAddress;

        $this->assertSame('US', $test->Principality);
        $this->assertSame('US', $test->Country);
        $this->assertSame('NY', $test->StateDistrict);
        $this->assertSame('New York', $test->Region);
        $this->assertSame('New York', $test->City);
        $this->assertSame('Manhattan', $test->SubCity);
        $this->assertSame('5th Ave', $test->Street);
        $this->assertSame('5th Ave', $test->SubStreet);
        $this->assertSame('350', $test->Building);
        $this->assertSame('350', $test->SubBuilding);
        $this->assertSame('Empire State Building', $test->Premise);
        $this->assertSame('10118', $test->ZipPostcode);
    }

    /**
     * @covers \ID3Global\Identity\Address\FreeFormatAddress
     */
    public function testFreeFormatAddress() {
        $identity = new Identity();
        $container = new AddressContainer();
        $address = new FreeFormatAddress();

        $address
            ->setCountry('New Zealand')
            ->setPostCode('6004')
            ->setAddressLine1('Room 6')
            ->setAddressLine2('Level 6')
            ->setAddressLine3('Area 6')
            ->setAddressLine4('666 Fake St')
            ->setAddressLine5('Te Aro')
            ->setAddressLine6('Wellington')
            ->setAddressLine7('6004')
            ->setAddressLine8('NZ');

        $container->setCurrentAddress($address);
        $identity->setAddresses($container);

        $r = new AuthenticateSPRequest();
        $r->addFieldsFromIdentity($identity);
        $test = $r->getInputData()->Addresses->CurrentAddress;

        $this->assertSame('New Zealand', $test->Country);
        $this->assertSame('6004', $test->PostCode);
        $this->assertSame('Room 6', $test->AddressLine1);
        $this->assertSame('Level 6', $test->AddressLine2);
        $this->assertSame('Area 6', $test->AddressLine3);
        $this->assertSame('666 Fake St', $test->AddressLine4);
        $this->assertSame('Te Aro', $test->AddressLine5);
        $this->assertSame('Wellington', $test->AddressLine6);
        $this->assertSame('6004', $test->AddressLine7);
        $this->assertSame('NZ', $test->AddressLine8);
    }

    /**
     * @covers \ID3Global\Identity\Documents\NZ\DrivingLicence
     */
    public function testNZDrivingLicence() {
        $identity = new Identity();
        $container = new DocumentContainer();
        $licence = new DrivingLicence();

        $licence
            ->setNumber('DI123456')
            ->setVersion(123)
            ->setVehicleRegistration('ABC123');

        $container->addIdentityDocument($licence, 'New Zealand');

        $identity->setIdentityDocuments($container);

        $r = new AuthenticateSPRequest();
        $r->addFieldsFromIdentity($identity);
        $test = $r->getInputData()->IdentityDocuments;

        $this->assertSame('DI123456', $test->NewZealand->DrivingLicence->Number);
        $this->assertSame(123, $test->NewZealand->DrivingLicence->Version);
        $this->assertSame('ABC123', $test->NewZealand->DrivingLicence->VehicleRegistration);
    }

    /**
     * @covers \ID3Global\Identity\Documents\IN\DrivingLicence
     */
    public function testINDocuments() {
        $identity = new Identity();
        $container = new DocumentContainer();
        $licence = new InDrivingLicence();
        $licence->setNumber('123456');
        $container->addIdentityDocument($licence, 'India');

        $epic = new Epic();
        $epic->setNumber('E123456');
        $container->addIdentityDocument($epic, 'India');

        $epic = new PAN();
        $epic->setNumber('P123456');
        $container->addIdentityDocument($epic, 'India');

        $identity->setIdentityDocuments($container);

        $r = new AuthenticateSPRequest();
        $r->addFieldsFromIdentity($identity);
        $test = $r->getInputData()->IdentityDocuments;

        $this->assertSame('123456', $test->India->DrivingLicence->Number);
        $this->assertSame('E123456', $test->India->Epic->Number);
        $this->assertSame('P123456', $test->India->PAN->Number);
    }

    /**
     * @covers \ID3Global\Identity\Documents\CA\SocialInsuranceNumber
     * @covers \ID3Global\Identity\Canada\SocialInsuranceNumber
     */
    public function testCADocuments() {
        $identity = new Identity();
        $container = new DocumentContainer();
        $sin = new SocialInsuranceNumber();
        $sin->setNumber('123456');
        $container->addIdentityDocument($sin, 'Canada');

        $identity->setIdentityDocuments($container);

        $r = new AuthenticateSPRequest();
        $r->addFieldsFromIdentity($identity);
        $test = $r->getInputData()->IdentityDocuments;
        $this->assertSame('123456', $test->Canada->SocialInsuranceNumber->Number);
    }

    /**
     * @covers \ID3Global\Identity\Documents\CN\ResidentIdentityCard
     */
    public function testCNResidentIdentityCard() {
        $identity = new Identity();
        $container = new DocumentContainer();
        $licence = new ResidentIdentityCard();

        $licence->setNumber('1234567890');
        $container->addIdentityDocument($licence, 'China');
        $identity->setIdentityDocuments($container);

        $r = new AuthenticateSPRequest();
        $r->addFieldsFromIdentity($identity);
        $test = $r->getInputData()->IdentityDocuments;

        $this->assertSame('1234567890', $test->China->ResidentIdentityCard->Number);
    }
}
