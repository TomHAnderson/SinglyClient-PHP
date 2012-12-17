<?php
/**
 * Singly Authentication
 *
 * @author Tom Anderson <tom.h.anderson@gmail.com
 * @license MIT
 */

namespace Singly\View\Helper;

use Zend\View\Helper\AbstractHelper,
    Singly\Service\Singly as SinglyService;

class Singly extends AbstractHelper
{
    protected $serviceSingly;

    public function __invoke()
    {
        if ($this->getService()) {
            return $this->getService();
        }

        throw new \Exception('Singly service has not been set on view helper');
    }

    public function getService()
    {
        return $this->serviceSingly;
    }

    public function setService(SinglyService $service)
    {
        $this->serviceSingly = $service;
        return $this;
    }
}