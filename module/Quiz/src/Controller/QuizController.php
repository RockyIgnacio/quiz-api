<?php

namespace Quiz\Controller;

use Quiz\Service\QuizService;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class QuizController extends AbstractRestfulController {
    private $QuizService;

    public function __construct(QuizService $QuizService) {
        $this->QuizService = $QuizService;
    }

    public function getList() {
        $exam = $this->QuizService->getActiveExam();
        return new JsonModel(
            array(
                "success" => true,
                "data" => $exam
            )
        );
    }

    public function get($id) {
        $questionRounds = $this->QuizService->getQuestionRounds($id);
        
        $questionRoundIds = [];
        foreach ($questionRounds as $questionRound) {
            $questionRoundIds[] = $questionRound->question_round_id;
        }
        $questions = $this->QuizService->getQuestions($questionRoundIds);

        $question_ids = [];
        foreach ($questions as $question) {
            $question_ids[] = $question->question_id;
        }
        $answers = $this->QuizService->getAnswers($question_ids);

        $parseData = $this->QuizService->parseData($questionRounds, $questions, $answers);
        return new JsonModel(
            array(
                "success" => true,
                "data" => $parseData
            )
        );
    }
}
