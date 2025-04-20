<?php

namespace Quiz\Model;

class Answers
{
    public $answer_id;
    public $question_id;
    public $answer;
    public $is_correct;

    public function exchangeArray(array $data)
    {
        $this->answer_id = isset($data['answer_id']) ? $data['answer_id'] : null;
        $this->question_id = isset($data['question_id']) ? $data['question_id'] : null;
        $this->answer = isset($data['answer']) ? $data['answer'] : null;
        $this->is_correct = isset($data['is_correct']) ? $data['is_correct'] : null;
    }
}