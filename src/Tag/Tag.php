<?php

namespace Anax\Tag;

use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * A database driven model using the Active Record design pattern.
 */
class Tag extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Tag";



    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $name;

    /**
     * Get all tags with number of threads using them
     *
     */
    public function findWithCount($limit)
    {
        $query = <<<EOD
SELECT id as tagId, name, description, ((SELECT count(id) FROM ThreadTag WHERE tag_id = tagId)) as numberOfThreads
FROM Tag
ORDER BY numberOfThreads DESC
LIMIT $limit;
EOD;

        $this->db->connect();
        $res = $this->db->executeFetchAll($query);

        return $res;
    }
}
