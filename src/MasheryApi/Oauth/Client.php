<?php

namespace MasheryApi\Oauth;

class Client extends \MasheryApi\Model
{
    /**
     * Client properties
     * @var array
     */
    protected $properties = array(
        'client_id' => array(
            'type' => 'string'
        ),
        'client_secret' => array(
            'type' => 'string'
        )
    );
}
