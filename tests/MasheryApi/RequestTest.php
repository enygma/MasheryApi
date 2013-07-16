<?php

class RequestTest extends \PHPUnit_Framework_TestCase
{
	private $request = null;

	public function setUp()
	{
		$this->request = new \MasheryApi\Request();
	}

	/**
	 * Test the getter/setter for the URL value
	 * 
	 * @covers \MasheryApi\Request::setUrl
	 * @covers \MasheryApi\Request::getUrl
	 */
	public function testGetSetUrl()
	{
		$url = 'http://google.com';
		$this->request->setUrl($url);

		$this->assertEquals(
			$this->request->getUrl(),
			$url
		);
	}

	/**
	 * Test the setting of a bad URL throws an error
	 * 
	 * @expectedException \InvalidArgumentException
	 */
	public function testSetInvalidUrl()
	{
		$url = 'badurlfail';
		$this->request->setUrl($url);
	}

	/**
	 * Test the getter/setter for the Site ID
	 * 
	 * @covers \MasheryApi\Request::getSiteId
	 * @covers \MasheryApi\Request::setSiteId
	 */
	public function testGetSetSiteId()
	{
		$siteId = 1234;
		$this->request->setSiteId($siteId);

		$this->assertEquals(
			$this->request->getSiteId(),
			$siteId
		);
	}

	/**
	 * Test the setting of an invalid Site ID
	 * 
	 * @expectedException \InvalidArgumentException
	 */
	public function testSetInvalidSiteId()
	{
		$siteId = 'badsiteidfail';
		$this->request->setSiteId($siteId);
	}

	/**
	 * Test the getter/setter for the Client object
	 * 	NOTE: This test uses a pseudo-object to test, 
	 *  	not an actual HTTP client
	 * 
	 * @covers \MasheryApi\Request::setClient
	 * @covers \MasheryApi\Request::getClient
	 */
	public function testGetSetClient()
	{
		$client = new \stdClass();
		$client->test = 'foo';

		$this->request->setClient($client);
		$this->assertEquals(
			$this->request->getClient(),
			$client
		);
	}

	/**
	 * Test the getter/setter for the API key
	 * 
	 * @covers \MasheryApi\Request::setApiKey
	 * @covers \MasheryApi\Request::getApiKey
	 */
	public function testGetSetApiKey()
	{
		$apiKey = 'valid-api-key';
		$this->request->setApiKey($apiKey);

		$this->assertEquals(
			$this->request->getApiKey(),
			$apiKey
		);
	}

	/**
	 * Test the getter/setter for the API secret key
	 * 
	 * @covers \MasheryApi\Request::setApiSecret
	 * @covers \MasheryApi\Request::getApiSecret
	 */
	public function testGetSetApiSecret()
	{
		$apiSecret = 'valid-api-secret';
		$this->request->setApiSecret($apiSecret);

		$this->assertEquals(
			$this->request->getApiSecret(),
			$apiSecret
		);
	}

	/**
	 * Test the generation of the signature hash for the request
	 * 
	 * @covers \MasheryApi\Request::generateSignature
	 * @covers \MasheryApi\Request::setApiKey
	 * @covers \MasheryApi\Request::setApiSecret
	 */
	public function testGenerateValidSignature()
	{
		$apiKey = 'valid-api-key';
		$apiSecret = 'valid-api-secret';
		$validHash = md5($apiKey.$apiSecret.time());

		$this->request->setApiKey($apiKey)
			->setApiSecret($apiSecret);

		$hash = $this->request->generateSignature();
		$this->assertEquals($hash, $validHash);
	}
}