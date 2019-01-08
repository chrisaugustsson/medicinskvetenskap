<?php
namespace Anax\Vote;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\User\HTMLForm\UserLoginForm;
use Anax\User\HTMLForm\CreateUserForm;
use Anax\User\HTMLForm\CreateThreadForm;
use Anax\User\HTMLForm\UserUpdateForm;
use Anax\Tag\Tag;
use Anax\Thread\Thread;
use Anax\Answer\Answer;
use Anax\Comment\Comment;

/**
 *
 *
 */
class VoteController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    public function voteActionPost() : object
    {
        $di = $this->di;

        $request = $di->get("request");
        $response = $di->get("response");

        $voteType = $request->getPost("type");
        $objectId = $request->getPost("id");
        $threadId = $request->getPost("thread");

        $voteUp = $request->getPost("vote-up");
        $voteDown = $request->getPost("vote-down");

        // Check if user is logged in
        $userLoggedIn = $di->get("session")->has("user");
        $user = $di->get("session")->get("user");

        $vote = new Vote();
        $vote->setDb($di->get("dbqb"));

        switch ($voteType) {
            case 'comment':
                $object = new Comment();
                break;
            case 'answer':
                $object = new Answer();
                break;
            case 'thread':
                $object = new Thread();
                break;
        }

        $object->setDb($di->get("dbqb"));

        if ($voteUp !== null && $userLoggedIn) {
            $vote->vote($objectId, $user, "up", $object, $voteType);
        }

        if ($voteDown !== null && $userLoggedIn) {
            $vote->vote($objectId, $user, "down", $object, $voteType);
        }

        return $response->redirect("thread/" . $threadId);
    }
}
