<?php
namespace Groups;

use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'groups_home' => [
                'type'    => 'Literal',
                'options' => [
                    // Change this to something specific to your module
                    'route'    => '/groups',
                    'defaults' => [
                        'controller' => 'Groups\Controller\IndexController',
                        'action'        => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'paged' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/page/:page' ,   // /groups/page/:page
                            'constraints' => [ 'page' => '[0-9]+' ],
                            'defaults' => [
                                'controller' => 'Groups\Controller\IndexController',
                                'action' => 'index'
                            ]
                        ]
                    ]
                ],
            ],
            'groups_add' => [
              'type' => 'Literal',
              'options' => [
                'route' => '/groups/add',
                'defaults' => [
                  'controller'  => 'Groups\Controller\IndexController',
                  'action'      => 'add'
                ]
              ]
            ],
            'groups_edit' => [
              'type' => 'Segment',
              'options' => [
                'route' => '/groups/edit/:itemId',
                'constraints' => [
                  'itemId' => '[0-9]+'
                ],
                'defaults' => [
                  'controller'  => 'Groups\Controller\IndexController',
                  'action'      => 'edit'
                ]
              ]
            ],
            'groups_delete' => [
              'type' => 'Segment',
              'options' => [
                'route' => '/groups/delete/:itemId',
                'constraints' => [
                  'itemId' => '[0-9]+'
                ],
                'defaults' => [
                  'controller'  => 'Groups\Controller\IndexController',
                  'action'      => 'delete'
                ]
              ]
            ]
        ],
    ],         
    'controllers' => [
        'factories' => [                                        
            'Groups\Controller\IndexController' => 'Groups\Controller\IndexControllerFactory'
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
           'groups' => __DIR__ . '/../view',
        ],
    ],
];
