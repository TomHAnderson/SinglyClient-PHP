<?php

namespace Singly\Service;

use Zend\Authentication\Adapter\AdapterInterface,
    Zend\Authentication\Result,
    Zend\Http\Client,
    Zend\Json\Json;

class Singly
{
    static $accessToken;
    static $clientId;
    static $clientSecret;
    static $redirectUri;

    static function configure($clientId, $clientSecret = '', $redirectUri = '')
    {
        if (is_array($clientId)) extract($clientId);
        self::setClientId($clientId);
        self::setClientSecret($clientSecret);
        self::setRedirectUri($redirectUri);
    }

    static function getClientId()
    {
        return self::$clientId;
    }

    static function setClientId($value)
    {
        self::$clientId = $value;
    }

    static function getClientSecret()
    {
        return self::$clientSecret;
    }

    static function setClientSecret($value)
    {
        self::$clientSecret = $value;
    }

    static function getRedirectUri()
    {
        return self::$redirectUri;
    }

    static function setRedirectUri($value)
    {
        self::$redirectUri = $value;
    }

    static function getLoginUrl($service, $options = array())
    {
        // Valid options are access_token, scope, and flag
        $qs = (!empty($options)) ? "&" . http_build_query($options) : "";
        return 'https://api.singly.com/oauth/authenticate?' .
            'client_id=' . self::getClientId() . '&' .
            'redirect_uri=' . self::getRedirectUri() . '&' .
            'service=' . $service . $qs;
    }

    static function deleteAll() {
        return self::deleteService();
    }

    static function deleteService($service = '')
    {
        self::verifyAccessToken();

        $http = new Client();
        $uri = 'https://api.singly.com/v0/profiles';
        $uri .= ($service) ? '/' . $service: '';
        $http->setUri($uri);
        $http->setMethod('DELETE');
        $http->setOptions(array('sslverifypeer' => false));

        $http->setParameterGet(array(
            'access_token' => self::getAccessToken()
        ));

        $response = $http->send();
        $content = $response->getBody();
        return Json::decode($content);
    }

    static function setAccessToken($accessToken)
    {
        self::$accessToken = $accessToken;
    }

    static function verifyAccessToken()
    {
        if (!self::getAccessToken())
            throw new \Exception('Access token has not been set');
    }

    static function getAccessToken($code = null)
    {
        if (!$code AND self::$accessToken)
            return self::$accessToken;

        if (!$code AND !self::$accessToken)
            return false;

        $http = new Client();
        $http->setUri('https://api.singly.com/oauth/access_token');
        $http->setMethod('POST');

        $http->setOptions(array('sslverifypeer' => false));
        $http->setParameterPost(array(
            'client_id' => self::getClientId(),
            'client_secret' => self::getClientSecret(),
            'code' => $code,
        ));

        $response = $http->send();

        if (!$response->isOk()) {
            throw new \Exception('Invalid access token');
        }

        $json = Json::decode($response->getBody());
        self::setAccessToken($json->access_token);

        return $json->access_token;
    }

    static function getServices($service = null, $endpoint = null, $options = array())
    {
        self::verifyAccessToken();

        $http = new Client();
        $uri = 'https://api.singly.com/v0/services';
        $uri .= ($service) ? '/' . $service: '';
        $uri .= ($service AND $endpoint) ? '/' . $endpoint: '';
        $http->setUri($uri);
        $http->setMethod('GET');
        $http->setOptions(array('sslverifypeer' => false));

        $options['access_token'] = self::getAccessToken();
        $http->setParameterGet($options);

        $response = $http->send();
        $content = $response->getBody();
        return Json::decode($content);
    }

    static function getTypes($type = null, $parameters = null)
    {
        self::verifyAccessToken();

        $http = new Client();
        $uri = 'https://api.singly.com/v0/types';
        $uri .= ($type) ? '/' . $type: '';
        $http->setUri($uri);
        $http->setMethod('GET');
        $http->setOptions(array('sslverifypeer' => false));

        $http->setParameterGet(array(
            'access_token' => self::getAccessToken()
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

    static function postTypes($type, $parameters = null)
    {
        self::verifyAccessToken();

        $http = new Client();
        $uri = 'https://api.singly.com/v0/types/' . $type;
        $http->setUri($uri);
        $http->setMethod('POST');
        $http->setOptions(array('sslverifypeer' => false));

        $http->setParameterGet(array(
            'access_token' => self::getAccessToken()
        ));

        foreach ((array)$parameters as $key => $val) {
            $http->setParameterPost(array(
                $key => $val
            ));
        }

        $response = $http->send();
        $content = $response->getBody();
        return Json::decode($content);
    }

    static function getProxy($service, $path, $parameters = null)
    {
        self::verifyAccessToken();

        $http = new Client();
        $uri = 'https://api.singly.com/proxy';
        $uri .= "/$service/$path";
        $http->setUri($uri);
        $http->setMethod('GET');
        $http->setOptions(array('sslverifypeer' => false));

        $http->setParameterGet(array(
            'access_token' => self::getAccessToken()
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

	static function getProfile($access_token = null)
	{
		self::verifyAccessToken();

		$http = new Client();
		$uri = 'https://api.singly.com/v0/profile';
		$http->setUri($uri);
		$http->setMethod('GET');
		$http->setOptions(array('sslverifypeer' => false));

		$http->setParameterGet(array(
			'access_token' => ($access_token) ? $access_token : self::getAccessToken()
		));

		$response = $http->send();
		$content = $response->getBody();
		return Json::decode($content);
	}

    static function getProfiles($service = null, $parameters = null)
    {
        self::verifyAccessToken();

        $http = new Client();
        $uri = 'https://api.singly.com/v0/profiles';
        $uri .= ($service) ? '/' . $service: '';
        $http->setUri($uri);
        $http->setMethod('GET');
        $http->setOptions(array('sslverifypeer' => false));

        $http->setParameterGet(array(
            'access_token' => self::getAccessToken()
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

    static function getById($id)
    {
        self::verifyAccessToken();

        $http = new Client();
        $uri = 'https://api.singly.com/id';
        $uri .= ($id) ? '/' . $id: '';
        $http->setUri($uri);
        $http->setMethod('GET');
        $http->setOptions(array('sslverifypeer' => false));

        $http->setParameterGet(array(
            'access_token' => self::getAccessToken()
        ));

        $response = $http->send();
        $content = $response->getBody();
        return Json::decode($content);
    }

    static function getByContact($service, $id, $parameters = null)
    {
        self::verifyAccessToken();

        $http = new Client();
        $uri = 'https://api.singly.com/v0/profiles';
        $uri .= ($service) ? '/' . $service: '';
        $uri .= ($id) ? '/' . $id: '';
        $http->setUri($uri);
        $http->setMethod('GET');
        $http->setOptions(array('sslverifypeer' => false));

        $http->setParameterGet(array(
            'access_token' => self::getAccessToken()
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

    static function getByUrl($url, $parameters = null)
    {
        self::verifyAccessToken();

        $http = new Client();
        $uri = 'https://api.singly.com/v0/profiles';
        $uri .= ($url) ? '/' . $url: '';
        $http->setUri($uri);
        $http->setMethod('GET');
        $http->setOptions(array('sslverifypeer' => false));

        $http->setParameterGet(array(
            'access_token' => self::getAccessToken()
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
