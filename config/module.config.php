<?php

return array(
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view'
        ),
        'helper_map' => array(
            'singly' => 'Singly\View\Helper\Singly'
        ),
    ),

    'controller' => array(
        'classes' => array(
            'singly' => 'Singly\Controller\SinglyController',
        ),
    ),

    'router' => array(
        'routes' => array(
            'singly' => array(
                'type' => 'Literal',
                'priority' => 1000,
                'options' => array(
                    'route' => '/user',
                    'defaults' => array(
                        'controller' => 'singly',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'login' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/login',
                            'defaults' => array(
                                'controller' => 'singly',
                                'action' => 'login',
                            ),
                        ),
                    ),
                    'takelogin' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/takelogin',
                            'defaults' => array(
                                'controller' => 'singly',
                                'action' => 'takelogin',
                            ),
                        ),
                    ),
                    'logout' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/logout',
                            'defaults' => array(
                                'controller' => 'singly',
                                'action' => 'logout',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),

    'di' => array(
        'instance' => array(
            'alias' => array(
                'singlyService' => 'Singly\Service\Singly',
                'singlyAdapter' => 'Singly\Authentication\Adapter\Singly',
                'authenticationService' => 'Zend\Authentication\AuthenticationService',
            ),

            'singlyService' => array(
                'parameters' => array()
            ),

            'singlyAdapter' => array(
                'parameters' => array(
                    'service' => 'singlyService',
                ),
            ),

            'Singly\View\Helper\Singly' => array(
                'parameters' => array(
                    'singlyService' => 'singlyService',
                ),
            ),

            'authenticationService' => array(
                'parameters' => array(
                    'storage' => null,
                    'adapter' => 'singlyAdapter',
                ),
            ),
        ),
    ),
);
