<?php

namespace Quiz;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\ExamTable::class => function($container) {
                    $tableGateway = $container->get(Model\ExamTableGateway::class);
                    return new Model\ExamTable($tableGateway);
                },
                Model\ExamTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Exam());
                    return new TableGateway('exams', $dbAdapter, null, $resultSetPrototype);
                },
                Model\QuestionRoundsTable::class => function($container) {
                    $tableGateway = $container->get(Model\QuestionRoundsTableGateway::class);
                    return new Model\QuestionRoundsTable($tableGateway);
                },
                Model\QuestionRoundsTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\QuestionRounds());
                    return new TableGateway('question_rounds', $dbAdapter, null, $resultSetPrototype);
                },
                Model\QuestionsTable::class => function($container) {
                    $tableGateway = $container->get(Model\QuestionsTableGateway::class);
                    return new Model\QuestionsTable($tableGateway);
                },
                Model\QuestionsTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Questions());
                    return new TableGateway('questions', $dbAdapter, null, $resultSetPrototype);
                },
                Model\AnswersTable::class => function($container) {
                    $tableGateway = $container->get(Model\AnswersTableGateway::class);
                    return new Model\AnswersTable($tableGateway);
                },
                Model\AnswersTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Answers());
                    return new TableGateway('answers', $dbAdapter, null, $resultSetPrototype);
                },


                Service\QuizService::class => function($container) {
                    return new Service\QuizService(
                        $container->get(Model\ExamTable::class),
                        $container->get(Model\QuestionRoundsTable::class),
                        $container->get(Model\QuestionsTable::class),
                        $container->get(Model\AnswersTable::class)
                    );
                },
            ],
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\QuizController::class => function($container) {
                    return new Controller\QuizController(
                        $container->get(Service\QuizService::class)
                    );
                },
            ],
        ];
    }
}