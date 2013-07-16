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
?>
```
