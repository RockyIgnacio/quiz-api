<?php

namespace Quiz\Model;

use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

class ExamTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getActiveExam()
    {
        $select = $this->tableGateway->getSql()->select();
        $select->join(array("a" => "activities"), "a.exam_id = exams.exam_id", 
            array('activity_id', 'activity_name', 'order'), "left")->where(
                array(
                    'active_flag' => 'y'
                )
            );

        $resultSet = $this->tableGateway->selectWith($select);   

        return ($resultSet->count() > 0 ? iterator_to_array($resultSet) : array());
    }

}
