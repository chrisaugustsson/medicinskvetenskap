<?php

namespace Anax\Vote;

use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * A database driven model using the Active Record design pattern.
 */
class Vote extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Vote";



    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $user;
    public $thread;
    public $answer;
    public $comment;

    public function vote($id, $user, $upOrDown, $object, $type)
    {
        $query = "SELECT * FROM Vote WHERE " . $type . " = ? and user = ?";

        $this->db->connect();
        $res = $this->db->executeFetchAll($query, [$id, $user]);

        if (sizeof($res) !== 0) {
            return "Already made a vote";
        }

        $object->findById($id);

        if ($upOrDown === "up") {
            $object->score += 1;
        } else {
            $object->score -= 1;
        }

        $object->save();

        $className = get_class($object);

        $vote = new Vote();
        $vote->setDb($this->db);

        switch ($className) {
            case 'Anax\Thread\Thread':
                $vote->thread = $id;
                break;
            case 'Anax\Answer\Answer':
                $vote->answer = $id;
                break;
            case 'Anax\Comment\Comment':
                $vote->comment = $id;
                break;
        }

        $vote->user = $user;

        $vote->save();
    }
}
