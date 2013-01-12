<?php

use Singly\Service\Singly;
use Zend\Session\Container as SessionContainer;

require_once __DIR__ . '/vendor/autoload.php';

$session = new SessionContainer('Singly');

// Configure the Singly variables
$config = array(
    'clientId' => '',
    'clientSecret' => '',
    'redirectUri' => 'http://localhost:8083/index.php',
);

// Create the Singly service object
Singly::configure($config);

// If a code is provided us that code to get an access token
if (isset($_GET['code'])) {
    $session->accessToken = Singly::getAccessToken($_GET['code']);
} else if (!Singly::getAccessToken()) {
    // No access token, Redirect to login
    header("Location: " . Singly::getLoginUrl('facebook'));
}

// Show some Facebook Feed using Singly
Singly::setAccessToken($session->accessToken);

echo "Last Status Updates: ";
echo '<pre>';
print_r(Singly::getServices('facebook', 'feed'));
echo '</pre>';
