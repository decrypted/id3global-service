<?php
namespace ID3Global\Tests;

use ID3Global\Stubs\Gateway\GlobalAuthenticationGatewayFake;
use ID3Global\Identity\Identity;
use ID3Global\Identity\PersonalDetails;
use \ID3Global\Service\GlobalAuthenticationService;
use PHPUnit\Framework\TestCase;

class GlobalAuthenticationServiceTest extends TestCase
{
    /**
     * @var GlobalAuthenticationService
     */
    private $service;

    /**
     * @var GlobalAuthenticationGatewayFake
     */
    private $fakeGateway;

    public function setUp(): void {
        $this->service = new GlobalAuthenticationService();
        $this->fakeGateway = new GlobalAuthenticationGatewayFake('username', 'password');

        $this->service->setGateway($this->fakeGateway);
    }

    /**
     * @covers \ID3Global\Gateway\Request\AuthenticateSPRequest
     * @covers \ID3Global\Stubs\Gateway\GlobalAuthenticationGatewayFake
     * @covers \ID3Global\Stubs\Gateway\GlobalAuthenticationGateway
     */
    public function testSuccessfulResponse() {
        $identity = $this->getSuccessfulIdentity();

        $this->service
            ->setCustomerReference('x')
            ->setIdentity($identity);

        $this->assertSame(Identity::IDENTITY_BAND_PASS, $this->service->verifyIdentity());

        $response = $this->service->getLastVerifyIdentityResponse();
        $this->assertSame(Identity::IDENTITY_BAND_PASS, $response->AuthenticateSPResult->BandText);
        $this->assertSame('Default Profile', $response->AuthenticateSPResult->ProfileName);
    }

    /**
     * @covers \ID3Global\Gateway\Request\AuthenticateSPRequest
     * @covers \ID3Global\Identity\Identity
     */
    public function testIdentityIsRequired() {
        try {
            $this->service->verifyIdentity();
        } catch (\Exception $e) {
            $this->assertSame('An Identity must be provided by setIdentity() before calling verifyIdentity()', $e->getMessage());
        }
    }

    /**
     * @covers \ID3Global\Gateway\Request\AuthenticateSPRequest
     * @covers \ID3Global\Identity\Identity
     * @covers \ID3Global\Service\GlobalAuthenticationService
     */
    public function testIdentityIsProperlyValidated() {
        $class = new \ReflectionClass('\ID3Global\Service\GlobalAuthenticationService');
        $property = $class->getProperty('identity');
        $property->setAccessible(true);
        $property->setValue($this->service, new \stdClass());

        try {
            $this->service->verifyIdentity();
        } catch (\Exception $e) {
            $this->assertSame('An Identity must be provided by setIdentity() before calling verifyIdentity()', $e->getMessage());
        }
    }

    private function getSuccessfulIdentity() {
        $personalDetails = new PersonalDetails();
        $personalDetails
            ->setForename('Snow')
            ->setMiddleName('White')
            ->setSurname('Huntsman')
            ->setGender('Female')
            ->setDateOfBirth(1976, 3, 6);

        $identity = new Identity();
        $identity->setPersonalDetails($personalDetails);

        return $identity;
    }
}
