<?php
namespace Units;

use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'units_home' => [
                'type'    => 'Literal',
                'options' => [
                    // Change this to something specific to your module
                    'route'    => '/units',
                    'defaults' => [
                        'controller' => 'Units\Controller\IndexController',
                        'action'        => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'paged' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/page/:page' ,   // /units/page/:page
                            'constraints' => [ 'page' => '[0-9]+' ],
                            'defaults' => [
                                'controller' => 'Units\Controller\IndexController',
                                'action' => 'index'
                            ]
                        ]
                    ]
                ],
            ],
            'units_add' => [
              'type' => 'Literal',
              'options' => [
                'route' => '/units/add',
                'defaults' => [
                  'controller'  => 'Units\Controller\IndexController',
                  'action'      => 'add'
                ]
              ]
            ],
            'edit_item' => [
              'type' => 'Segment',
              'options' => [
                'route' => '/units/edit/:itemId',
                'constraints' => [
                  'itemId' => '[0-9]+'
                ],
                'defaults' => [
                  'controller'  => 'Units\Controller\IndexController',
                  'action'      => 'edit'
                ]
              ]
            ],
            'delete_item' => [
              'type' => 'Segment',
              'options' => [
                'route' => '/units/delete/:itemId',
                'constraints' => [
                  'itemId' => '[0-9]+'
                ],
                'defaults' => [
                  'controller'  => 'Units\Controller\IndexController',
                  'action'      => 'delete'
                ]
              ]
            ],
            'display_item' => [
              'type' => 'Segment',
              'options' => [
                'route' => '/units/:itemName',
                'contraints' => [
                  'itemSlug'      => '[a-zA-Z0-9-]+',
                ],
                'defaults' => [
                  'controller'  => 'Units\Controller\IndexController',
                  'action'      => 'viewitem'
                ]
              ]
            ]
        ],
    ],         
    'controllers' => [
        'factories' => [                                        
            'Units\Controller\IndexController' => 'Units\Controller\IndexControllerFactory',  
            'Units\Controller\UnitsItem' => 'Units\Controller\UnitsItemControllerFactory'
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
           'units' => __DIR__ . '/../view',
        ],
    ],
];
