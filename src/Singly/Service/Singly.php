<?php

namespace Singly\Service;

use Singly\Service\Exception\InvalidArgumentException,
    Zend\Authentication\Adapter\AdapterInterface,
    Zend\Authentication\Result,
    Zend\Http\Client,
    Zend\Json\Json,
    Singly\Module,
    Zend\Session\Container as SessionContainer,
    Zend\ServiceManager\ServiceManager;

class Singly {
    private $accessToken;
    private $serviceManager;

    public function __construct($serviceManager) {
        $this->setServiceManager($serviceManager);
    }

    public function setServiceManager(ServiceManager $manager) {
        $this->serviceManager = $manager;
        return $this;
    }

    public function getServiceManager() {
        return $this->serviceManager;
    }

    public function getIdentity() {
        $auth = $this->getServiceManager()->get('authenticationService');

        if ($auth->hasIdentity()) {
            return $auth->getIdentity();
        } else {
            return false;
        }
    }

    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
        return $this;
    }

    public function getAccessToken($code = null) {
        $session = new SessionContainer('Singly');
        if (isset($session->access_token)) {
            return $session->access_token;
        }

        if (!$code AND !$this->accessToken)
            throw new \Exception('No access token provided');

        if (!$code AND $this->accessToken)
            return $this->accessToken;

        $http = new Client();
        $http->setUri('https://api.singly.com/oauth/access_token');
        $http->setMethod('POST');

        $http->setParameterPost(array(
            'client_id' => Module::getOption('client_id'),
            'client_secret' => Module::getOption('client_secret'),
            'code' => $code,
        ));

        $response = $http->send();

        if (!$response->isOk()) {
            throw new \Exception('Invalid access token');
        }

        $json = Json::decode($response->getBody());
        $this->setAccessToken($json->access_token);
        $session->access_token = $json->access_token;

        return $this->accessToken;
    }

    public function getServices($service = null, $endpoint = null)
    {
        if (!$this->getAccessToken())
            throw new InvalidArgumentException('Access token has not been set');

        $http = new Client();
        $uri = 'https://api.singly.com/v0/services';
        $uri .= ($service) ? '/' . $service: '';
        $uri .= ($service AND $endpoint) ? '/' . $endpoint: '';
        $http->setUri($uri);
        $http->setMethod('GET');

        $http->setParameterGet(array(
            'access_token' => $this->getAccessToken()
        ));

        $response = $http->send();
        $content = $response->getBody();
        return Json::decode($content);
    }

    public function getTypes($type = null, $parameters = null)
    {
        if (!$this->getAccessToken())
            throw new InvalidArgumentException('Access token has not been set');

        $http = new Client();
        $uri = 'https://api.singly.com/v0/types';
        $uri .= ($type) ? '/' . $type: '';
        $http->setUri($uri);
        $http->setMethod('GET');

        $http->setParameterGet(array(
            'access_token' => $this->getAccessToken()
        ));

        foreach ((array)$parameters as $key => $val) {
            $http->setParameterGet(array(
                $key => $val
            ));
        }

        $response = $http->send();
        $content = $response->getBody();
        return Json::decode($content);
    }

    public function getProxy($service, $path, $parameters = null)
    {
        if (!$this->getAccessToken())
            throw new InvalidArgumentException('Access token has not been set');

        $http = new Client();
        $uri = 'https://api.singly.com/proxy';
        $uri .= "/$service/$path";
        $http->setUri($uri);
        $http->setMethod('GET');

        $http->setParameterGet(array(
            'access_token' => $this->getAccessToken()
        ));

        foreach ((array)$parameters as $key => $val) {
            $http->setParameterGet(array(
                $key => $val
            ));
        }

        $response = $http->send();
        $content = $response->getBody();
        return Json::decode($content);
    }

    public function getProfiles($service = null, $parameters = null) {
        if (!$this->getAccessToken())
            throw new InvalidArgumentException('Access token has not been set');

        $http = new Client();
        $uri = 'https://api.singly.com/v0/profiles';
        $uri .= ($service) ? '/' . $service: '';
        $http->setUri($uri);
        $http->setMethod('GET');

        $http->setParameterGet(array(
            'access_token' => $this->getAccessToken()
        ));

        foreach ((array)$parameters as $key => $val) {
            $http->setParameterGet(array(
                $key => $val
            ));
        }

        $response = $http->send();
        $content = $response->getBody();
        return Json::decode($content);
    }

    public function getById($id) {
        if (!$this->getAccessToken())
            throw new InvalidArgumentException('Access token has not been set');

        $http = new Client();
        $uri = 'https://api.singly.com/id';
        $uri .= ($id) ? '/' . $id: '';
        $http->setUri($uri);
        $http->setMethod('GET');

        $http->setParameterGet(array(
            'access_token' => $this->getAccessToken()
        ));

        $response = $http->send();
        $content = $response->getBody();
        return Json::decode($content);
    }

    public function getByContact($service, $id, $parameters = null) {
        if (!$this->getAccessToken())
            throw new InvalidArgumentException('Access token has not been set');

        $http = new Client();
        $uri = 'https://api.singly.com/v0/profiles';
        $uri .= ($service) ? '/' . $service: '';
        $uri .= ($id) ? '/' . $id: '';
        $http->setUri($uri);
        $http->setMethod('GET');

        $http->setParameterGet(array(
            'access_token' => $this->getAccessToken()
        ));

        foreach ((array)$parameters as $key => $val) {
            $http->setParameterGet(array(
                $key => $val
            ));
        }

        $response = $http->send();
        $content = $response->getBody();
        return Json::decode($content);
    }

    public function getByUrl($url, $parameters = null) {
        if (!$this->getAccessToken())
            throw new InvalidArgumentException('Access token has not been set');

        $http = new Client();
        $uri = 'https://api.singly.com/v0/profiles';
        $uri .= ($url) ? '/' . $url: '';
        $http->setUri($uri);
        $http->setMethod('GET');

        $http->setParameterGet(array(
            'access_token' => $this->getAccessToken()
        ));

        foreach ((array)$parameters as $key => $val) {
            $http->setParameterGet(array(
                $key => $val
            ));
        }

        $response = $http->send();
        $content = $response->getBody();
        return Json::decode($content);
    }
}