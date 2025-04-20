<?php

namespace Quiz\Model;

class Exam
{
    public $exam_id;
    public $exam_name;
    public $heading;
    public $activity_id;
    public $activity_name;
    public $order;

    public function exchangeArray(array $data)
    {
        $this->exam_id     = isset($data['exam_id']) ? $data['exam_id'] : null;
        $this->exam_name  = isset($data['exam_name']) ? $data['exam_name'] : null;
        $this->heading = isset($data['heading']) ? $data['heading'] : null;
        $this->activity_id = isset($data['activity_id']) ? $data['activity_id'] : null;
        $this->activity_name = isset($data['activity_name']) ? $data['activity_name'] : null;
        $this->order = isset($data['order']) ? $data['order'] : null;
    }
}