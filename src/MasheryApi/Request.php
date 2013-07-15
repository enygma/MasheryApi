<?php

namespace MasheryApi;

class Request
{
	/**
	 * URL for API request
	 * @var string
	 */
	private $url = 'http://api.mashery.com/v2/json-rpc';

	/**
	 * Site ID for your site
	 * @var integer
	 */
	private $siteId = null;

	/**
	 * Mashery API key
	 * @var string
	 */
	private $apiKey = null;

	/**
	 * Mashery API secret
	 * @var string
	 */
	private $apiSecret = null;

	/**
	 * Current HTTP client (probably Guzzle)
	 * @var object
	 */
	private $client = null;

	/**
	 * Get the current URL setting
	 * 
	 * @return string URL
	 */
	public function getUrl()
	{
		return $this->url;
	}

	/**
	 * Set the current URL value
	 * 
	 * @param string $url Base API URL
	 */
	public function setUrl($url)
	{
		if (filter_var($url, FILTER_VALIDATE_URL) !== $url) {
			throw new \InvalidArgumentException('URL "'.$url.'" is not valid');
		}
		$this->url = $url;
		return $this;
	}

	/**
	 * Site ID for Mashery API
	 * 
	 * @param string $siteId Site ID
	 */
	public function setSiteId($siteId)
	{
		if (!is_numeric($siteId)) {
			throw new \InvalidArgumentException('Invalid Site ID: '.$siteId);
		}
		$this->siteId = $siteId;
		return $this;
	}

	/**
	 * Get the current Site ID setting
	 * 
	 * @return integer Site ID
	 */
	public function getSiteId()
	{
		return $this->siteId;
	}

	/**
	 * Set the HTTP client for requests (probably Guzzle)
	 * 
	 * @param object $client HTTP client
	 */
	public function setClient($client)
	{
		$this->client = $client;
		return $this;
	}

	/**
	 * Get the current HTTP client
	 * 
	 * @return object HTTP client
	 */
	public function getClient()
	{
		return $this->client;
	}

	/**
	 * Set the Mashery API key for the request
	 * 
	 * @param string $apiKey API key
	 */
	public function setApiKey($apiKey)
	{
		$this->apiKey = $apiKey;
		return $this;
	}

	/**
	 * Get the current Mashery API key
	 * 
	 * @return string API key
	 */
	public function getApiKey()
	{
		return $this->apiKey;
	}

	/**
	 * Set the current Mashery API secret value
	 * 
	 * @param string $apiSecret API secret hash
	 */
	public function setApiSecret($apiSecret)
	{
		$this->apiSecret = $apiSecret;
		return $this;
	}

	/**
	 * Get the current API secret value
	 * 
	 * @return string API secret hash
	 */
	public function getApiSecret()
	{
		return $this->apiSecret;
	}

	/**
	 * Geenrate the request signature
	 * 
	 * @return string Request signature hash
	 */
	public function generateSignature()
	{
		return md5(
			$this->getApiKey().
			$this->getApiSecret().
			time()
		);
	}

	/**
	 * Send the request to the Mashery API
	 * 
	 * @param string $data JSON to send in request
	 * @return object API response (JSON object)
	 */
	public function send($data = null)
	{
		$client = $this->getClient();
		$params = array(
			'apikey' => $this->getApiKey(),
			'sig' => $this->generateSignature()
		);
		$url = $this->getUrl().'/'.$this->getSiteId().'?'.http_build_query($params);

		$request = $client->post($url);
		$request->setBody($data, 'application/json');

		$response = $request->send();
		$result = json_decode($response->getBody(true));
		return $result;
	}
}