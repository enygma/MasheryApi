<?php

namespace MasheryApi\Oauth;

class Tokendata extends \MasheryApi\Model
{
    /**
     * Token data properties
     * @var array
     */
    protected $properties = array(
        'grant_type' => array(
            'type' => 'string'
        ),
        'scope' => array(
            'type' => 'string'
        ),
        'code' => array(
            'type' => 'string'
        ),
        'response_type' => array(
            'type' => 'string'
        ),
        'refresh_token' => array(
            'type' => 'string'
        ),
        'access_token' => array(
            'type' => 'string'
        ),
    );
}
