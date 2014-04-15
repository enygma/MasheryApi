<?php

namespace MasheryApi\Oauth;

class Accesstoken extends \MasheryApi\Model
{
    /**
     * Access token properties
     * @var array
     */
    protected $properties = array(
        'access_token' => array(
            'type' => 'string'
        ),
        'token_type' => array(
            'type' => 'string'
        ),
        'expires_in' => array(
            'type' => 'string'
        ),
        'refresh_token' => array(
            'type' => 'string'
        ),
        'scope' => array(
            'type' => 'string'
        ),
        'state' => array(
            'type' => 'string'
        ),
        'uri' => array(
            'type' => 'string'
        ),
        'extended' => array(
            'type' => 'string'
        )
    );

    /**
     * Create the access token
     *
     * @param string $serviceKey Service key string
     * @param \MasheryApi\Oauth\Client $client Client object
     * @param \MasheryApi\Oauth\Tokendata $tokenData Token data object
     * @throws \Exception If there is an error creating the token (from API)
     */
    public function create($serviceKey, $client, $tokenData)
    {
        $data = array(
            'service_key' => $serviceKey,
            'client' => array(
                'client_id'     => $client->client_id,
                'client_secret' => $client->client_secret
            ),
            'token_data' => array(
                'grant_type' => $tokenData->grant_type,
                'scope' => $tokenData->scope,
                'code' => $tokenData->code//,
                // 'response_type' => null,
                // 'refresh_token' => ''
            ),
            'uri' => array(
                'redirect_uri' => 'https:\/\/client.example.com\/cb'
            ),
            'user_context' => null
        );

        $data = json_encode(array(
            'jsonrpc' => '2.0',
            'method' => 'oauth2.createAccessToken',
            'params' => $data,
            'id' => 1
        ));

        try {
            $result = $this->getRequest()->send($data);
            if ($result->result !== null) {
                $this->values((array)$result->result);
            }
            return $this;
        } catch (\Exception $e) {
            throw new \Exception('There was an error creating access token: '
                .$e->getMessage()."\n"
                .$e->getResponse()->getBody(true)
            );
        }
    }
}