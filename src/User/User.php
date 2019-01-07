<?php

namespace Anax\User;

use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * A database driven model.
 */
class User extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "User";

    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $acronym;
    public $firstName;
    public $lastName;
    public $email;
    public $password;
    // public $created;
    public $gravatar;

    /**
     * Set the password.
     *
     * @param string $password the password to use.
     *
     * @return void
     */
    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Verify the acronym and the password, if successful the object contains
     * all details from the database row.
     *
     * @param string $acronym  acronym to check.
     * @param string $password the password to use.
     *
     * @return boolean true if acronym and password matches, else false.
     */
    public function verifyPassword($acronym, $password)
    {
        $this->find("acronym", $acronym);
        return password_verify($password, $this->password);
    }

    /**
     * Gets the 5 latest posts
     *
     */
    public function findLatest($acronym)
    {
        $query = "SELECT title, owner, published, id as thisID, (SELECT count(id) FROM Comment WHERE threadID = thisID) AS comment FROM Thread WHERE owner = ?";

        $this->db->connect();
        $res = $this->db->executeFetchAll($query, [$acronym]);

        return $res;
    }

    /**
     * Get user.
     *
     * @param string $acronym the acronym to find.
     *
     * @return void
     */
    public function findUserProfile($acronym)
    {
        $query = "SELECT firstName, lastName, acronym, gravatar, email, created FROM User WHERE acronym = ?";

        $this->db->connect();
        $res = $this->db->executeFetchAll($query, [$acronym]);

        return $res;
    }

    /**
     * Get user.
     *
     * @param string $acronym the acronym to find.
     *
     * @return void
     */
    public function findUsersWithNrOfThreads()
    {
        $query = <<<EOD
SELECT acronym, gravatar, email, (SELECT COUNT(*) FROM Thread WHERE owner = acronym) as nrOfThreads
FROM User
ORDER BY nrOfThreads DESC
LIMIT 3
;
EOD;

        $this->db->connect();
        $res = $this->db->executeFetchAll($query);

        return $res;
    }
}
