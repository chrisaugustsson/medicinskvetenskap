<?php
namespace Anax\Comment;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\User\HTMLForm\UserLoginForm;
use Anax\User\HTMLForm\CreateUserForm;
use Anax\User\HTMLForm\CreateThreadForm;
use Anax\User\HTMLForm\UserUpdateForm;
use Anax\Tag\Tag;
use Anax\Thread\Thread;

/**
 *
 *
 */
class CommentController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    /**
     * Creates a new Comment on a answer.
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function newActionPost() : object
    {
        $response = $this->di->get("response");
        $request = $this->di->get("request");
        $session = $this->di->get("session");

        // Get user
        $user = $session->get("user");

        // Get all post params
        $answerId = $request->getPost("answer");
        $content = $request->getPost("content");
        $thread = $request->getPost("thread");

        // Filter markdown text
        $filter = $this->di->get("textfilter");
        $filteredContent = $filter->doFilter($content, "markdown");

        // Create a new comment
        $comment = new Comment();
        $comment->setDb($this->di->get("dbqb"));
        $comment->owner = $user;
        $comment->answerID = $answerId;
        $comment->content = $filteredContent;
        $comment->save();

        return $response->redirect("thread/" . $thread);
    }
}
