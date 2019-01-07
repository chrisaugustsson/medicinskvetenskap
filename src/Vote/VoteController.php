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

    public function threadActionPost() : object
    {
        $di = $this->di;

        $request = $di->get("request");
        $response = $di->get("response");

        $threadId = $request->getPost("thread");
        $voteUp = $request->getPost("vote-up");
        $voteDown = $request->getPost("vote-down");

        $thread = new Thread();
        $thread->setDb($this->di->get("dbqb"));

        // Check if user is logged in
        $userLoggedIn = $di->get("session")->has("user");
        $user = $di->get("session")->get("user");

        if ($voteUp !== null && $userLoggedIn) {
            $thread->vote($threadId, $user, "up");
        }

        if ($voteDown !== null && $userLoggedIn) {
            $thread->vote($threadId, $user, "down");
        }

        return $response->redirect("thread/" . $threadId);
    }

    public function answerActionPost() : object
    {
        $di = $this->di;

        $request = $di->get("request");
        $response = $di->get("response");

        $answerId = $request->getPost("answer");
        $threadId = $request->getPost("thread");
        $voteUp = $request->getPost("vote-up");
        $voteDown = $request->getPost("vote-down");

        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));

        // Check if user is logged in
        $userLoggedIn = $di->get("session")->has("user");
        $user = $di->get("session")->get("user");

        if ($voteUp !== null && $userLoggedIn) {
            $answer->vote($answerId, $user, "up");
        }

        if ($voteDown !== null && $userLoggedIn) {
            $answer->vote($answerId, $user, "down");
        }

        return $response->redirect("thread/" . $threadId);
    }

    public function commentActionPost() : object
    {
        $di = $this->di;

        $request = $di->get("request");
        $response = $di->get("response");

        $commentId = $request->getPost("comment");
        $threadId = $request->getPost("thread");
        $voteUp = $request->getPost("vote-up");
        $voteDown = $request->getPost("vote-down");

        $comment = new Comment();
        $comment->setDb($this->di->get("dbqb"));

        // Check if user is logged in
        $userLoggedIn = $di->get("session")->has("user");
        $user = $di->get("session")->get("user");

        if ($voteUp !== null && $userLoggedIn) {
            $comment->vote($commentId, $user, "up");
        }

        if ($voteDown !== null && $userLoggedIn) {
            $comment->vote($commentId, $user, "down");
        }

        return $response->redirect("thread/" . $threadId);
    }
}
