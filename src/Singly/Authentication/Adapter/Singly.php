<?php
/**
 * Singly Authentication
 *
 * @author Tom Anderson <tom.h.anderson@gmail.com
 * @license MIT
 */

namespace Singly\Authentication\Adapter;

use Zend\Authentication\Adapter\AdapterInterface,
    Zend\Authentication\Result,
    Zend\Http\Client,
    Zend\Json\Json,
    Zend\Authentication\Exception\InvalidArgumentException;

class Singly implements AdapterInterface
{
    private $service;

    public function setService($service)
    {
        $this->service = $service;
        return $this;
    }

    public function getService()
    {
        return $this->service;
    }

    public function authenticate()
    {
        $http = new Client();
        $http->setUri('https://api.singly.com/profiles');
        $http->setMethod('GET');
        $http->setOptions(array('sslverifypeer' => false));

        $http->setParameterGet(array(
            'access_token' => $this->getService()->getAccessToken()
        ));

        $response = $http->send();

        if (!$response->isOk()) {
            return new Result(Result::FAILURE_CREDENTIAL_INVALID, null, array());
        }

        $content = $response->getBody();
        $decoded = Json::decode($content);

        return new Result(Result::SUCCESS, $decoded->id, array());
    }
}