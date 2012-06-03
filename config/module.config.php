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
                    'register' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/register',
                            'defaults' => array(
                                'controller' => 'singly',
                                'action' => 'register',
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
                // Models
                'modelSingly' => 'Singly\Model\Singly',
                'authenticationService' => 'Zend\Authentication\AuthenticationService',
                'singlyAdapter' => 'Singly\Authentication\Adapter\Singly',
            ),

            'authenticationService' => array(
                'parameters' => array(
                    'storage' => null,
                    'adapter' => 'singlyAdapter',
                ),
            ),

            'Singly\View\Helper\Singly' => array(
                'parameters' => array(
                    'authService' => 'authenticationService',
                ),
            ),

        ),
    ),
);
