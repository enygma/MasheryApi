<?php

namespace MasheryApi\Oauth;

class Uri extends \MasheryApi\Model
{
    /**
     * URI properties
     * @var array
     */
    protected $properties = array(
        'redirect_uri' => array(
            'type' => 'string'
        ),
        'state' => array(
            'type' => 'string'
        )
    );
}
