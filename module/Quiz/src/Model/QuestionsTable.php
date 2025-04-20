<?php

namespace Quiz\Model;

use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

class QuestionsTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getQuestions($questionRoundIds)
    {
        $select = $this->tableGateway->getSql()->select();
        $select->where(array(
            'question_round_id' => $questionRoundIds
        ));
        
        $resultSet = $this->tableGateway->selectWith($select);   

        return ($resultSet->count() > 0 ? iterator_to_array($resultSet) : array());
    }
}
