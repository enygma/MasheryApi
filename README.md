MasheryAPI
==================

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

?>
```