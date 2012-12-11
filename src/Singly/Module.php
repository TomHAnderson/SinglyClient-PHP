<?php
/**
 * Singly Authentication
 *
 * @author Tom Anderson <tom.h.anderson@gmail.com
 * @license MIT
 */

namespace Singly;

use Zend\Mvc\ModuleRouteListener,
    Zend\ModuleManager\ModuleManager,
    Zend\EventManager\EventManager,
    Zend\EventManager\StaticEventManager;

class Module {
    protected static $options;

    public function init(ModuleManager $moduleManager)
    {
        $moduleManager->getEventManager()->attach(
            'loadModules.post',
            array($this, 'modulesLoaded')
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    public function modulesLoaded($e)
    {
        $config = $e->getConfigListener()->getMergedConfig();
        static::$options = $config['singly'];
    }

    public static function getOption($option)
    {
        if (!isset(static::$options[$option])) {
            return null;
        }
        return static::$options[$option];
    }

    public function setEventManager(EventManager $eventManager) {
        $this->eventManager = $eventManager;
        return $this;
    }

    public function getEventManager() {
        return StaticEventManager::getInstance();
    }

}
