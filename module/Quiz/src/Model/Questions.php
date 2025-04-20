<?php

namespace Quiz\Model;

class Questions
{
    public $question_round_id;
    public $question_id;
    public $stimulus;
    public $order;

    public function exchangeArray(array $data)
    {
        $this->question_round_id = isset($data['question_round_id']) ? $data['question_round_id'] : null;
        $this->question_id = isset($data['question_id']) ? $data['question_id'] : null;
        $this->stimulus = isset($data['stimulus']) ? $data['stimulus'] : null;
        $this->order = isset($data['order']) ? $data['order'] : null;
    }
}