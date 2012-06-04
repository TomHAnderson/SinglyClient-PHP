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
    Singly\Module,
    Zend\Authentication\Exception\InvalidArgumentException;

class Singly implements AdapterInterface {

    private $code;

    public function setCode($code) {
        $this->code = $code;
        return $this;
    }

    public function getCode() {
        return $this->code;
    }

    public function authenticate() {

        if (!$this->getCode()) throw new InvalidArgumentException('Code has not been set');

        // Validate the access token
        $http = new Client();
        $http->setUri('https://api.singly.com/oauth/access_token');
        $http->setMethod('POST');

        $http->setParameterPost(array(
            'client_id' => Module::getOption('client_id'),
            'client_secret' => Module::getOption('client_secret'),
            'code' => $this->getCode(),
        ));

        $response = $http->send();

        if (!$response->isOk()) {
            return new Result(Result::FAILURE_CREDENTIAL_INVALID, null, array());
        }

        $json = Json::decode($response->getBody());
        $token = $json->access_token;

        // Fetch the user's profile
        $http = new Client();
        $http->setUri('https://api.singly.com/profiles');
        $http->setMethod('GET');

        $http->setParameterGet(array(
            'access_token' => $token
        ));

        $response = $http->send();
        $content = $response->getBody();
        $decoded = Json::decode($content);

        return new Result(Result::SUCCESS, $decoded->id, array());
    }

}