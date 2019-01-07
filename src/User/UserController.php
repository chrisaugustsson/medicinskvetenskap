<?php
namespace Anax\User;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\User\HTMLForm\UserLoginForm;
use Anax\User\HTMLForm\CreateUserForm;
use Anax\User\HTMLForm\CreateThreadForm;
use Anax\User\HTMLForm\UserUpdateForm;
use Anax\Tag\Tag;
use Anax\Thread\Thread;
use Anax\Answer\Answer;
use Anax\ThreadTag\ThreadTag;
use Anax\Comment\Comment;
use Anax\Vote\Vote;

/**
 *
 *
 */
class UserController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    public function usersAction() : object
    {
        $title = "Hem";
        $di = $this->di;

        $request = $di->get("request");
        $page = $di->get("page");

        $user = new User();
        $user->setDb($di->get("dbqb"));
        $users = $user->findAll();

        $page->add("anax/user/users", [
            "users" => $users
        ]);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function profilAction($acronym) : object
    {
        $session = $this->di->get("session");
        $response = $this->di->get("response");
        $page = $this->di->get("page");
        $loggedIn = false;

        if ($session->get("user") === $acronym) {
            $loggedIn = true;
        }

        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $currentUser = $user->findUserProfile($acronym);

        $thread = new Thread();
        $thread->setDb($this->di->get("dbqb"));
        $threads = $thread->findWithID("owner = ?", [$acronym]);

        $threadTag = new ThreadTag();
        $threadTag->setDb($this->di->get("dbqb"));

        $comment = new Comment();
        $comment->setDb($this->di->get("dbqb"));
        $comments = $comment->findWithOrigin($acronym);

        $vote = new Vote();
        $vote->setDb($this->di->get("dbqb"));
        $votes = $vote->findAll();

        $allTags = [];

        foreach ($threads as $currentThread) {
            $allTags[$currentThread->thisID] = $threadTag->findTags($currentThread->thisID);
        }

        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));
        $answers = $answer->findAllWhere("owner = ?", $acronym);

        if (sizeof($currentUser) === 0) {
            $page->add("anax/user/noUserFound", [
            ]);

            return $page->render([
                "title" => "Hittade inte användare",
            ]);
        }

        $page->add("anax/user/profil", [
            "user" => $currentUser[0],
            "threads" => $threads,
            "loggedIn" => $loggedIn,
            "answers" => $answers,
            "tags" => $allTags,
            "comments" => $comments
        ]);

        return $page->render([
            "title" => "Logga in",
        ]);
    }

    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function newThreadAction() : object
    {
        $session = $this->di->get("session");
        $response = $this->di->get("response");
        $page = $this->di->get("page");
        $request = $this->di->get("request");

        if ($session->get("user") === null) {
            $response->redirect("user/login");
        }

        $form = new CreateThreadForm($this->di);
        $form->check();

        $page->add("anax/thread/newThread", [
            "content" => $form->getHTML(),
            "dummyContent" => [1, 2, 3, 4, 5, 6]
        ]);

        return $page->render([
            "title" => "Ny tråd",
        ]);
    }

    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function loginAction() : object
    {
        $session = $this->di->get("session");
        $response = $this->di->get("response");
        $page = $this->di->get("page");
        $form = new UserLoginForm($this->di);
        $form->check();

        if ($session->get("user") !== null) {
            $response->redirect("index");
        }

        $page->add("anax/v2/article/default", [
            "content" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Logga in",
        ]);
    }

    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function registreraAction() : object
    {
        $page = $this->di->get("page");
        $form = new CreateUserForm($this->di);
        $form->check();

        $user = new User();
        $user->setDb($this->di->get("dbqb"));

        $page->add("anax/v2/article/default", [
            "content" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "A create user page"
        ]);
    }

    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function editAction() : object
    {
        $session = $this->di->get("session");
        $response = $this->di->get("response");

        if ($session->get("user") === null) {
            $response->redirect("user/login");
        }

        $page = $this->di->get("page");
        $form = new UserUpdateForm($this->di);
        $form->check();

        $user = new User();
        $user->setDb($this->di->get("dbqb"));

        $page->add("anax/v2/article/default", [
            "content" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "A create user page"
        ]);
    }

    public function logoutActionGet() : object
    {
        $this->di->get("session")->delete("user");

        return $this->di->get("response")->redirect("index");
    }
}
