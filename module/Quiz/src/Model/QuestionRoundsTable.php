<?php

namespace Quiz\Model;

use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

class QuestionRoundsTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getQuestionRounds($activityId)
    {
        $select = $this->tableGateway->getSql()->select();
        $select->where(array(
            'activity_id' => $activityId
        ));
        
        $resultSet = $this->tableGateway->selectWith($select);   

        return ($resultSet->count() > 0 ? iterator_to_array($resultSet) : array());
    }
}
