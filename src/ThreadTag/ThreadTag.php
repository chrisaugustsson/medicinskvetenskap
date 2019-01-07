<?php

namespace Anax\ThreadTag;

use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * A database driven model using the Active Record design pattern.
 */
class ThreadTag extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "ThreadTag";



    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $tag_id;
    public $thread_id;

    public function findTags($threadId)
    {
        $query = "SELECT tag_id, (SELECT name FROM Tag WHERE id = tag_id) as name FROM ThreadTag WHERE thread_id = ?";
        $this->db->connect();
        $res = $this->db->executeFetchAll($query, [$threadId]);

        return $res;
    }

    public function findTagsWithParams($where, $params)
    {
        $query = "SELECT tag_id, (SELECT name FROM Tag WHERE id = tag_id) as name FROM ThreadTag WHERE " . $where;
        $this->db->connect();
        $res = $this->db->executeFetchAll($query, $params);

        return $res;
    }
}
