<?php

namespace GlobalPayments\Api\Tests\Integration\Gateways\PorticoConnector;

use GlobalPayments\Api\ServicesConfig;
use GlobalPayments\Api\ServicesContainer;
use GlobalPayments\Api\Tests\Data\TestCards;
use PHPUnit\Framework\TestCase;

class EbtTest extends TestCase
{
    protected $card;
    protected $track;

    public function setup()
    {

        $this->card = TestCards::asEBTManual(TestCards::visaManual(), '32539F50C245A6A93D123412324000AA');
        $this->track = TestCards::asEBTTrack(TestCards::visaSwipeEncrypted(), '32539F50C245A6A93D123412324000AA');

        ServicesContainer::configure($this->getConfig());
    }

    public function testEbtBalanceInquiry()
    {
        $response = $this->card->balanceInquiry()
            ->execute();
        $this->assertNotNull($response);
        $this->assertEquals('00', $response->responseCode);
    }

    public function testEbtSale()
    {
        $response = $this->card->charge(10)
            ->withCurrency('USD')
            ->withAllowDuplicates(true)
            ->execute();
        $this->assertNotNull($response);
        $this->assertEquals('00', $response->responseCode);
    }

    public function testEbtRefund()
    {
        $response = $this->card->refund(10)
            ->withCurrency('USD')
            ->withAllowDuplicates(true)
            ->execute();
        $this->assertNotNull($response);
        $this->assertEquals('00', $response->responseCode);
    }

    public function testEbtSwipeBalanceInquiry()
    {
        $response = $this->track->balanceInquiry()
            ->execute();
        $this->assertNotNull($response);
        $this->assertEquals('00', $response->responseCode);
    }

    public function testEbtSwipeSale()
    {
        $response = $this->track->charge(10)
            ->withCurrency('USD')
            ->withAllowDuplicates(true)
            ->execute();
        $this->assertNotNull($response);
        $this->assertEquals('00', $response->responseCode);
    }

    public function testEbtSwipeRefund()
    {
        $response = $this->track->refund(10)
            ->withCurrency('USD')
            ->withAllowDuplicates(true)
            ->execute();
        $this->assertNotNull($response);
        $this->assertEquals('00', $response->responseCode);
    }

    protected function getConfig()
    {
        $config = new ServicesConfig();
        $config->secretApiKey = 'skapi_cert_MaePAQBr-1QAqjfckFC8FTbRTT120bVQUlfVOjgCBw';
        $config->serviceUrl = 'https://cert.api2.heartlandportico.com';
        return $config;
    }
}
