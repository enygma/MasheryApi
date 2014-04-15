MasheryAPI
==================

[![Build Status](https://secure.travis-ci.org/enygma/MasheryApi.png?branch=master)](http://travis-ci.org/enygma/MasheryApi)

The MasheryApi library makes connecting to the Mashery management API simpler
through a basic PHP interface.

## Sample Usage:

```php
<?php

require_once 'vendor/autoload.php';

$client = new \Guzzle\Http\Client();
$request = new \MasheryApi\Request();

$request->setClient($client)
	->setApiKey('api-key-here')
	->setApiSecret('api-secret-here')
	->setSiteId('site-id-here');

$service = new \MasheryApi\Service();
$service->setRequest($request);

$member = $service->getMember('mashery-username');

echo 'Member: '; echo $member->username."\n";

// To create a user
$data = array(
	'username' => 'newuser1',
	'display_name' => 'New User 1',
	'email' => 'user@newuser.com'
);
$service->addMember($data);

// To enable a user
$service->enableMember($member);

// To disable a user
$service->disableMember($member);

// To delete a member
$service->deleteMember($member);

// Using the MQL queries (object.fetch)
$results = $service->getObject('SELECT name from ROLES');
print_r($results->items);

// Fetching an OAuth access token
$uri = new \MasheryApi\Oauth\Uri();
$uri->redirect_uri = 'https:\/\/client.example.com\/cb';

$client = new \MasheryApi\Oauth\Client();
$client->client_id = 'client-id-here';
$client->client_secret = 'client-secret-here';

try {
    $authCode = $service->oauth->authcode->create($serviceKey, $client, $uri);

    $tokenData = new \MasheryApi\Oauth\Tokendata();
    $tokenData->grant_type = 'authorization_code';
    $tokenData->scope = 'myscope';
    $tokenData->code = $authCode->code;

    $token = $service->oauth->accesstoken->create($serviceKey, $client, $tokenData);
} catch (\Exception $e) {
    echo "\n\n##### ERROR #####################\n";
    echo $e->getMessage()."\n\n";
}

echo 'token: '.$token->access_token."\n";
?>
```
