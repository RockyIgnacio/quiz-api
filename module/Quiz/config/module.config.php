<?php

namespace Quiz;

use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'view_manager' => [
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],
    'router' => [
        'routes' => [
            'get-exam-activities' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/get-exam-activities',
                    'defaults' => [
                        'controller' => Controller\QuizController::class,
                    ],
                ],
            ],
            'get-activity-questions' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/get-activity-questions/:id',
                    'defaults' => [
                        'controller' => Controller\QuizController::class,
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\QuizController::class => function ($container) {
                return new Controller\QuizController(
                    $container->get(Service\QuizService::class)
                );
            },
        ],
    ],
];
