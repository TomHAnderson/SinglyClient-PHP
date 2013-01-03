Singly PHP Library
===============================
This is a library to abstract the Singly API to PHP objects.  

Example 
-------
An example application is included on the ```example``` branch.  See the README.md in that branch for details.

Installation
------------
  1. edit `composer.json` file with following contents:

     ```json
     "require": {
        "singly/singly-tha": "dev-master"
     }
     ```
  2. install composer via `curl -s http://getcomposer.org/installer | php` (on windows, download
     http://getcomposer.org/installer and execute it with PHP)
  3. run `php composer.phar install`

Use
---
Create the Singly service
```php
$singly = new \Singly\Service\Singly($clientId, $clientSecret, $redirectUri);

// Get a login url to authorize a service
$loginUrl = $singly->getLoginUrl('facebook');
```

De-authorize a service.  This will un-link a service from the user's profile.
```php
$singly->deleteService('facebook');
```

De-authorize all services.  This will delete a user's profile.
```php
$singly->deleteAll();
```

Get an access token in a redirectUri / callback handler
```php
$code = $_GET['code'];
$singly->setAccessToken($singly->getAccessToken($code));
```

API Services
```php
// Profiles
$singly->getProfiles($service = null, $parameters = null);

// Services
$singly->getServices($service = null, $endpoint = null, $parameters = array());

// Types
$singly->getTypes($type = null, $parameters = null);

// Global Items
$singly->getById($id);

// Proxy to Service API
$singly->getProxy($service, $path, $parameters = null)

// By URL
$singly->getByUrl($url, $parameters = null);

// By Contact ID
$singly->getByContact($service, $id, $parameters = null);
```
A view helper object is also provided which returns the Singly service object
```php
// Within a view
$singly = $this->singly();
```

