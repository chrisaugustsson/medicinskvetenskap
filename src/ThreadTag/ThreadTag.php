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
    public $tagId;
    public $threadId;

    public function findTags($threadId)
    {
        $query = "SELECT tagId, (SELECT name FROM Tag WHERE id = tagId) as name FROM ThreadTag WHERE threadId = ?";
        $this->db->connect();
        $res = $this->db->executeFetchAll($query, [$threadId]);

        return $res;
    }

    public function findTagsWithParams($where, $params)
    {
        $query = "SELECT tagId, (SELECT name FROM Tag WHERE id = tagId) as name FROM ThreadTag WHERE " . $where;
        $this->db->connect();
        $res = $this->db->executeFetchAll($query, $params);

        return $res;
    }
}
