Singly Authentication for Zend Framework 2 
==========================================

The Singly module provides authentication against any of singly.com's 
providers.  

Installation
------------
#### Installation steps
  1. begin with a Zend Framework 2 skeleton application
  2. edit the `composer.json` file with following contents:

     ```json
     "require": {
         "TomHAnderson/Singly": "dev-master"
     }
     ```
  3. install composer via `curl -s http://getcomposer.org/installer | php` (on windows, download
     http://getcomposer.org/installer and execute it with PHP)
  4. run `php composer.phar install`
  5. open `my/project/directory/configs/application.config.php` and add following keys to your `modules`

     ```php
     'Singly',
     ```
  6. drop `vendor/TomHAnderson/Singly/config/module.singly.local.php.dist` into your application's
     `config/autoload` directory, rename it to `module.singly.local.php` and make the appropriate changes.


URLs
-----
http://localhost/user/login
Show the available services from Singly to login

http://localhost/user 
Show the authenticated user

http://localhost/user/logout
End the authentication session
