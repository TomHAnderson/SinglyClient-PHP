<?php
/**
 * Singly Authentication
 *
 * @author Tom Anderson <tom.h.anderson@gmail.com
 * @license MIT
 */

namespace Singly\View\Helper;

use Zend\View\Helper\AbstractHelper,
    Zend\Authentication\AuthenticationService,
    Singly\Service\Singly as SinglyService;

class Singly extends AbstractHelper
{
    /**
     * @var AuthenticationService
     */
    protected $singlyService;

    /**
     * __invoke
     *
     * @access public
     * @return ZfcUser\Model\UserInterface
    */
    public function __invoke()
    {
        if ($this->getService()) {
            return $this->getService();
        }

        throw new \Exception('Singly service has not been set on view helper');
    }

    /**
     * Get authService.
     *
     * @return AuthenticationService
     */
    public function getService()
    {
        return $this->singlyService;
    }

    /**
     * Set authService.
     *
     * @param AuthenticationService $authService
     */
    public function setService(SinglyService $service)
    {
        $this->singlyService = $service;
        return $this;
    }
}