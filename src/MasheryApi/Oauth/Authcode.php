<?php

namespace MasheryApi\Oauth;

class Authcode extends \MasheryApi\Model
{
    /**
     * Token data properties
     * @var array
     */
    protected $properties = array(
        'code' => array(
            'type' => 'string'
        )
    );

    /**
     * Create a new Authentication code
     *
     * @param string $serviceKey Service key string
     * @param \MasheryApi\Oauth\Client $client Client object
     * @param \MasheryApi\Oauth\Tokendata $tokenData Token data object
     * @throws \Exception If there is an error creating the token (from API)
     */
    public function create($serviceKey, $client, $uri)
    {
        $data = json_encode(array(
            'jsonrpc' => '2.0',
            'method' => 'oauth2.createAuthorizationCode',
            'params' => array(
                'service_key' => $serviceKey,
                'client' => $client->toArray(),
                'uri' => $uri->toArray(),
                'user_context' => null
            ),
            'id' => 1
        ));

        try {
            $result = $this->getRequest()->send($data);
            if ($result->result !== null) {
                $this->values((array)$result->result);
            }
            return $this;
        } catch (\Exception $e) {
            throw new \Exception('There was an error creating authentication token: '
                .$e->getMessage()."\n"
                .$e->getResponse()->getBody(true)
            );
        }
    }
}