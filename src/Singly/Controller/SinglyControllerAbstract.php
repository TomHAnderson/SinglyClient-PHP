<?php
/**
 * Singly Authentication
 *
 * @author Tom Anderson <tom.h.anderson@gmail.com
 * @license MIT
 */

namespace Singly\Controller;

use Zend\Mvc\Controller\ActionController,
    Zend\Authentication\AuthenticationService,
    Singly\Authentication\Adapter\Singly;

class SinglyControllerAbstract extends ActionController
{

    public function loginAction() {
        $auth = $this->getServiceLocator()->get('authenticationService');

        if ($auth->hasIdentity()) {
            return $this->plugin('redirect')->toUrl('/user');
        }

        return array();
    }

    public function takeloginAction()
    {
        $code = $this->getRequest()->query()->get('code');
        $singly= $this->getServiceLocator()->get('singlyService');
        // Sending code to getAccessToken authenticates the code
        $singly->getAccessToken($code);

        $auth = $this->getServiceLocator()->get('authenticationService');
        $result = $auth->authenticate();

        if (!$result->isValid()) throw new \Exception('Invalid auth token returned');

        return $this->plugin('redirect')->toUrl('/user');
    }

    public function indexAction()
    {
        $auth = $this->getServiceLocator()->get('authenticationService');

        if (!$auth->hasIdentity()) {
            return $this->plugin('redirect')->toUrl('/user/login');
        }

        return array(
        );
    }

    public function logoutAction() {

        $auth = $this->getServiceLocator()->get('authenticationService');
        $auth->clearIdentity();

        return array();
    }
}

