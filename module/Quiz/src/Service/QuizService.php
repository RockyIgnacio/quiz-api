<?php

namespace Quiz\Service;
use Quiz\Model\ExamTable;
use Quiz\Model\QuestionRoundsTable;
use Quiz\Model\QuestionsTable;
use Quiz\Model\AnswersTable;

class QuizService
{
    protected $ExamTable;
    protected $QuestionRoundsTable;
    protected $QuestionsTable;

    public function __construct(
        ExamTable $ExamTable,
        QuestionRoundsTable $QuestionRoundsTable,
        QuestionsTable $QuestionsTable,
        AnswersTable $AnswersTable
    ) {
        $this->ExamTable = $ExamTable;
        $this->QuestionRoundsTable = $QuestionRoundsTable;
        $this->QuestionsTable = $QuestionsTable;
        $this->AnswersTable = $AnswersTable;
    }

    public function getActiveExam()
    {
        $results = $this->ExamTable->getActiveExam();
    
        if (empty($results)) {
            return [];
        }
    
        $grouped = [];
    
        foreach ($results as $row) {
            $examId = $row->exam_id;
    
            if (!isset($grouped[$examId])) {
                $grouped[$examId] = [
                    'exam_id' => $row->exam_id,
                    'exam_name' => $row->exam_name,
                    'heading' => $row->heading,
                    'activities' => []
                ];
            }
    
            $grouped[$examId]['activities'][] = [
                'activity_id' => $row->activity_id,
                'activity_name' => $row->activity_name,
                'order' => $row->order
            ];
        }
    
        return array_values($grouped);
    }
 
    public function getQuestionRounds($activityId) {
        $results = $this->QuestionRoundsTable->getQuestionRounds($activityId);
        return $results;
    }

    public function getQuestions($questionRoundIds) {
        $results = $this->QuestionsTable->getQuestions($questionRoundIds);
        return $results;
    }

    public function getAnswers($questionIds) {
        $results = $this->AnswersTable->getAnswers($questionIds);
        return $results;
    }

    public function parseData($questionRounds, $questions, $answers) {
        $answersByQuestionId = [];
        foreach ($answers as $answer) {
            $question_id = $answer->question_id;
            $answersByQuestionId[$question_id][] = $answer;
        }
        
        $questionsByRoundId = [];
        foreach ($questions as $question) {
            $question_id = $question->question_id;
            $question->answers = $answersByQuestionId[$question_id] ?? [];
        
            $round_id = $question->question_round_id;
            $questionsByRoundId[$round_id][] = $question;
        }
        
        $parseData = [];
        foreach ($questionRounds as $round) {
            $round_id = $round->question_round_id;
            $round->questions = $questionsByRoundId[$round_id] ?? [];
            $parseData[] = $round;
        }
        
        return $parseData;
    }
}
