<?php

namespace Quiz\Model;

use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

class AnswersTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getAnswers($questionIds)
    {
        $select = $this->tableGateway->getSql()->select();
        $select->where(array(
            'question_id' => $questionIds
        ));
        
        $resultSet = $this->tableGateway->selectWith($select);   

        return ($resultSet->count() > 0 ? iterator_to_array($resultSet) : array());
    }
}
