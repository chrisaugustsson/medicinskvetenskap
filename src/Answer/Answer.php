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

    public function vote($id, $user, $upOrDown)
    {
        $query = "SELECT * FROM Vote WHERE answer = ? and user = ?";

        $this->db->connect();
        $res = $this->db->executeFetchAll($query, [$id, $user]);

        if (sizeof($res) !== 0) {
            return "Already made a vote";
        }

        $answer = new Answer();
        $answer->setDb($this->db);

        $answer->findById($id);

        if ($upOrDown === "up") {
            $answer->score += 1;
        } else {
            $answer->score -= 1;
        }

        $answer->save();

        $vote = new Vote();
        $vote->setDb($this->db);

        $vote->user = $user;
        $vote->answer = $id;
        $vote->save();
    }

    /**
     * Gets the 5 latest posts
     *
     */
    public function findByOrder($order, $id)
    {
        $query = <<<EOD
SELECT * FROM Answer WHERE threadID = ?
ORDER BY $order DESC
EOD;
        $this->db->connect();
        $res = $this->db->executeFetchAll($query, [$id]);
        var_dump($res);
        return $res;

    }
}
