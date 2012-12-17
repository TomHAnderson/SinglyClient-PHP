ZF2 Singly Module
==========================================

The Singly module provides authentication against any of singly.com's 
providers and API access through a service object.

Singly documentation may be found at https://singly.com/docs

Installation
------------
#### Installation steps
  1. begin with a Zend Framework 2 skeleton application
  2. edit the `composer.json` file with following contents:

     ```json
     "require": {
         "singly/singly-zf2-module": "dev-master"
     }
     ```
  3. install composer via `curl -s http://getcomposer.org/installer | php` (on windows, download
     http://getcomposer.org/installer and execute it with PHP)
  4. run `php composer.phar install`
  5. open `my/project/directory/configs/application.config.php` and add following keys to your `modules`

     ```php
     'Singly',
     ```
  6. drop `vendor/singly/singly-zf2-module/config/module.singly.local.php.dist` into your application's
     `config/autoload` directory, rename it to `module.singly.local.php` and make the appropriate changes.

Authentication
--------------
http://localhost/singly/login
    Show the available services from Singly to login

http://localhost/singly
    Show the authenticated user

http://localhost/singly/logout
    End the authentication session
    
Usage
--------
Once a user is authenticated at /singly/login you may use the Singly service object to interact with the API

```php
// Init service object
$singly = $this->getServiceLocator()->get('serviceSingly');

// Get auth identity 
$id = $singly->getIdentity();
```
API Services through Singly
```php
// Profiles
$singly->getProfiles($service = null, $parameters = null);

// Services
$singly->getServices($service = null, $endpoint = null, $options = array());

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

Example Application
-------------------
An example application is included on the ```example``` branch.  See the README.md in that branch for details.
