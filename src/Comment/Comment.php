<?php

namespace Anax\Comment;

use Anax\DatabaseActiveRecord\ActiveRecordModel;
use Anax\Vote\Vote;

/**
 * A database driven model using the Active Record design pattern.
 */
class Comment extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Comment";



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
    public $answerID;


    /**
     * Finds all comments made by a user together with the threadId.
     *
     * @var string $acronym of the user.
     *
     * @return array with the result.
     */
    public function findWithOrigin($acronym)
    {
        $query = "select *, (select threadID from Answer where id = answerID) as origin from Comment where owner = ?;";

        $this->db->connect();
        $res = $this->db->executeFetchAll($query, [$acronym]);
        return $res;
    }
}
