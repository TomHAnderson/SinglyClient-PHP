<?php
/**
 * Singly Authentication
 *
 * @author Tom Anderson <tom.h.anderson@gmail.com
 * @license MIT
 */

namespace Singly\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\Authentication\AuthenticationService,
    Singly\Authentication\Adapter\Singly;

class SinglyControllerAbstract extends AbstractActionController
{

    public function loginAction() {
        $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');

        if ($auth->hasIdentity()) {
            return $this->plugin('redirect')->toUrl('/singly');
        }

        return array();
    }

    public function takeloginAction()
    {
        $code = $this->getRequest()->getQuery()->get('code');
        $singly= $this->getServiceLocator()->get('serviceSingly');
        // Sending code to getAccessToken authenticates the code
        $singly->getAccessToken($code);

        $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        $result = $auth->authenticate();

        if (!$result->isValid()) throw new \Exception('Invalid auth token returned');

        return $this->plugin('redirect')->toUrl('/singly');
    }

    public function indexAction()
    {
        $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');

        if (!$auth->hasIdentity()) {
            return $this->plugin('redirect')->toUrl('/singly/login');
        }

        return array(
        );
    }

    public function logoutAction() {

        $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        $auth->clearIdentity();

        return array();
    }
}

