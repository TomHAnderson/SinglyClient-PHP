<?php
/**
 * Singly Authentication
 *
 * @author Tom Anderson <tom.h.anderson@gmail.com
 * @license MIT
 */

return array(
    'Singly\Module'                              => __DIR__ . '/Module.php',
    'Singly\Authentication\Adapter\Singly'       => __DIR__ . '/src/Singly/Authentication/Adapter/Singly.php',
    'Singly\Controller\SinglyController'         => __DIR__ . '/src/Singly/Controller/SinglyController.php',
    'Singly\Controller\SinglyControllerAbstract' => __DIR__ . '/src/Singly/Controller/SinglyControllerAbstract.php',
    'Singly\View\Helper\Singly'                  => __DIR__ . '/src/Singly/View/Helper/Singly.php',
);
