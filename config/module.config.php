<?php

namespace Singly;

return array(
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view'
        ),
    ),

    'view_helpers' => array(
        'invokables' => array(
            'singly' => 'Singly\View\Helper\Singly',
        ),
    ),

    'controllers' => array(
        'invokables' => array(
            'singly' => 'Singly\Controller\SinglyController'
        ),
    ),

    'router' => array(
        'routes' => array(
            'singly' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/singly',
                    'defaults' => array(
                        'controller' => 'singly',
                        'action'     => 'index',
                    ),
                ),
            ),
            'singlyLogin' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/singly/login',
                    'defaults' => array(
                        'controller' => 'singly',
                        'action' => 'login',
                    ),
                ),
            ),
            'singlyTakeLogin' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/singly/takelogin',
                    'defaults' => array(
                        'controller' => 'singly',
                        'action' => 'takelogin',
                    ),
                ),
            ),
            'singlyLogout' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/singly/logout',
                    'defaults' => array(
                        'controller' => 'singly',
                        'action' => 'logout',
                    ),
                ),
            ),
        ),
    ),

    'di' => array(
        'instance' => array(
            'alias' => array(
                'serviceSingly' => 'Singly\Service\Singly',
                'adapterSingly' => 'Singly\Authentication\Adapter\Singly',
            ),

            'serviceSingly' => array(
                'parameters' => array(
                    'serviceManager' => 'Zend\ServiceManager\ServiceManager',
                )
            ),

            'adapterSingly' => array(
                'parameters' => array(
                    'service' => 'serviceSingly',
                ),
            ),

            'Singly\View\Helper\Singly' => array(
                'parameters' => array(
                    'service' => 'serviceSingly',
                ),
            ),

            'Zend\Authentication\AuthenticationService' => array(
                'parameters' => array(
                    'storage' => null,
                    'adapter' => 'adapterSingly',
                ),
            ),
        ),
    ),
);
