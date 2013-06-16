Singly PHP Library
===============================
This library abstracts the Singly API to PHP service object.  

Example 
-------
An example application is included on the ```example``` branch.  See the README.md in that branch for details.

Installation
------------
  1. edit `composer.json` file with following contents:

     ```json
     "require": {
        "singly/singly": "dev-master"
     }
     ```
  2. install composer via `curl -s http://getcomposer.org/installer | php` (on windows, download
     http://getcomposer.org/installer and execute it with PHP)
  3. run `php composer.phar install`

Use
---
Create the Singly service
```php
use \Singly\Service\Singly;

Singly::configure($clientId, $clientSecret, $redirectUri);
Singly::setAccessToken('access_token');

// Get a login url to authorize a service
$loginUrl = Singly::getLoginUrl('facebook');
```

De-authorize a service.  This will un-link a service from the user's profile.
```php
Singly::deleteService('facebook');
```

De-authorize all services.  This will delete a user's profile.
```php
Singly::deleteAll();
```

Get an access token in a redirectUri / callback handler.
Getting an access token with code sets to access token too.
```php
$code = $_GET['code'];
Singly::getAccessToken($code);
```

API Services
```php
// Get Login URL
Singly::getLoginUrl($service, $options());
// Valid options: access_token, scope, flag

// Simple Unified Profile
Singly::getProfile($access_token = null);

// Profiles
Singly::getProfiles($service = null, $parameters = null);

// Services
Singly::getServices($service = null, $endpoint = null, $parameters = array());

// Types
Singly::getTypes($type = null, $parameters = null);

// Post to Types
// https://singly.com/docs/sharing
Singly::postTypes($type, $parameters = null);

// Global Items
Singly::getById($id);

// Proxy to Service API
Singly::getProxy($service, $path, $parameters = null)

// By URL
Singly::getByUrl($url, $parameters = null);

// By Contact ID
Singly::getByContact($service, $id, $parameters = null);
```
