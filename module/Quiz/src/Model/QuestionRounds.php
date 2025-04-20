<?php

namespace Quiz\Model;

class QuestionRounds
{
    public $question_round_id;
    public $activity_id;
    public $round_title;
    public $order;

    public function exchangeArray(array $data)
    {
        $this->question_round_id = isset($data['question_round_id']) ? $data['question_round_id'] : null;
        $this->activity_id = isset($data['activity_id']) ? $data['activity_id'] : null;
        $this->round_title = isset($data['round_title']) ? $data['round_title'] : null;
        $this->order = isset($data['order']) ? $data['order'] : null;
    }
}