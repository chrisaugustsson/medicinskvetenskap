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

    public function findWithOrigin($acronym)
    {
        $query = "select *, (select threadID from answer where id = answerID) as origin from Comment where owner = ?;";

        $this->db->connect();
        $res = $this->db->executeFetchAll($query, [$acronym]);
        return $res;
    }

    public function vote($id, $user, $upOrDown)
    {
        $query = "SELECT * FROM Vote WHERE comment = ? and user = ?";

        $this->db->connect();
        $res = $this->db->executeFetchAll($query, [$id, $user]);

        if (sizeof($res) !== 0) {
            return "Already made a vote";
        }

        $comment = new Comment();
        $comment->setDb($this->db);

        $comment->findById($id);

        if ($upOrDown === "up") {
            $comment->score += 1;
        } else {
            $comment->score -= 1;
        }

        $comment->save();

        $vote = new Vote();
        $vote->setDb($this->db);

        $vote->user = $user;
        $vote->comment = $id;
        $vote->save();
    }
}
