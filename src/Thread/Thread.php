<?php

namespace Anax\Thread;

use Anax\DatabaseActiveRecord\ActiveRecordModel;
use Anax\Vote\Vote;

/**
 * A database driven model using the Active Record design pattern.
 */
class Thread extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Thread";



    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $title;
    public $content;
    public $owner;
    public $score;


    public function findLatest()
    {
        $query = "SELECT title, owner, published, score, id as thisID, (SELECT count(id) FROM Answer WHERE threadID = thisID) AS answer FROM Thread ORDER BY published DESC LIMIT 5";

        $this->db->connect();
        $res = $this->db->executeFetchAll($query);

        return $res;
    }


    public function findEvery($limit1, $limit2, $order)
    {
        // $query = "SELECT title, owner, published, score, id as thisID, (SELECT count(id) FROM Answer WHERE threadID = thisID) AS answer FROM Thread ORDER BY published DESC LIMIT";
        $query = <<<EOD
SELECT title, owner, published, score, id as thisID, (SELECT count(id) FROM Answer WHERE threadID = thisID) AS answer
FROM Thread ORDER BY $order DESC
LIMIT $limit1, $limit2
EOD;
        // $query .= " ". $limit1 . ", " . $limit2;
        $this->db->connect();
        $res = $this->db->executeFetchAll($query);

        return $res;

    }

    public function findWithID($where, $params)
    {
        $query = "SELECT title, score, owner, published, id as thisID, (SELECT count(id) FROM Answer WHERE threadID = thisID) AS answer FROM Thread WHERE " . $where;

        $this->db->connect();
        $res = $this->db->executeFetchAll($query, $params);

        return $res;
    }
}
