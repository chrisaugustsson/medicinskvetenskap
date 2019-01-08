<?php

namespace Anax\Answer;

use Anax\DatabaseActiveRecord\ActiveRecordModel;
use Anax\Vote\Vote;

/**
 * A database driven model using the Active Record design pattern.
 */
class Answer extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Answer";



    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $owner;
    public $content;
    public $score;
    public $threadID;

    /**
     * Finds all the answers that is connected to a certain thread.
     * Returns it in desirerd order.
     *
     * @var string $order as the order to sort the answers
     * @var integer $id of the thread.
     *
     * @return array with the result.
     */
    public function findByOrder($order, $id)
    {
        $query = <<<EOD
SELECT * FROM Answer WHERE threadID = ?
ORDER BY $order DESC
EOD;
        $this->db->connect();
        $res = $this->db->executeFetchAll($query, [$id]);

        return $res;

    }
}
