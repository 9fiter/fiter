<?php

namespace Fiter\Payment\BitcoinBundle\Tests\Functional\Bitcoin;

use Fiter\Payment\BitcoinBundle\Client\Authentication\TokenAuthenticationStrategy;
use Fiter\Payment\BitcoinBundle\Client\Client;

class ClientTest extends \PHPUnit_Framework_TestCase{

    /**
     * @var \Fiter\Payment\BitcoinBundle\Client\Client
     */
    protected $client;

    protected function setUp(){
        if (empty($_SERVER['API_USERNAME']) || empty($_SERVER['API_PASSWORD']) || empty($_SERVER['API_SIGNATURE'])) {
            $this->markTestSkipped('In order to run these tests you have to configure: API_USERNAME, API_PASSWORD, API_SIGNATURE parameters in phpunit.xml file');
        }

        $authenticationStrategy = new TokenAuthenticationStrategy(
            $_SERVER['API_USERNAME'],
            $_SERVER['API_PASSWORD'],
            $_SERVER['API_SIGNATURE']
        );

        $this->client = new Client($authenticationStrategy, $debug = true);
    }
    public function testRequestSetExpressCheckout(){
        $response = $this->client->requestSetExpressCheckout(123.43, 'http://www.foo.com/returnUrl', 'http://www.foo.com/cancelUrl');

        $this->assertInstanceOf('Fiter\Payment\BitcoinBundle\Client\Response', $response);
        $this->assertTrue($response->body->has('TOKEN'));
        $this->assertTrue($response->isSuccess());
        $this->assertEquals('Success', $response->body->get('ACK'));
    }
    public function testRequestGetExpressCheckoutDetails(){
        $response = $this->client->requestSetExpressCheckout('123', 'http://www.foo.com/', 'http://www.foo.com/');

        //guard
        $this->assertInstanceOf('Fiter\Payment\BitcoinBundle\Client\Response', $response);
        $this->assertTrue($response->body->has('TOKEN'));

        $response = $this->client->requestGetExpressCheckoutDetails($response->body->get('TOKEN'));

        $this->assertTrue($response->body->has('TOKEN'));
        $this->assertTrue($response->body->has('CHECKOUTSTATUS'));
        $this->assertEquals('PaymentActionNotInitiated', $response->body->get('CHECKOUTSTATUS'));
        $this->assertEquals('Success', $response->body->get('ACK'));
    }
}