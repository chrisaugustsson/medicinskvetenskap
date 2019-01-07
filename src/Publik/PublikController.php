<?php
namespace Anax\Publik;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\Thread\Thread;
use Anax\Comment\Comment;
use Anax\ThreadTag\ThreadTag;
use Anax\Tag\Tag;
use Anax\Answer\Answer;
use Anax\Thread\HTMLForm\CreateAnswerForm;
use Anax\Comment\HTMLForm\CreateCommentForm;
use Anax\User\User;

/**
 *
 *
 */
class PublikController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;


    /**
     * Display the input field for IP address.
     *
     * @return object
     */
    public function indexActionGet() : object
    {
        $title = "Hem";
        $di = $this->di;

        $page = $di->get("page");

        // Init Thread object
        $thread = new Thread();
        $thread->setDb($this->di->get("dbqb"));

        $tag = new Tag();
        $tag->setDb($di->get("dbqb"));
        $tags = $tag->findWithCount(3);

        $user = new User();
        $user->setDb($di->get("dbqb"));
        $users = $user->findUsersWithNrOfThreads();

        // Init ThreadTag
        $threadTag = new ThreadTag();
        $threadTag->setDb($this->di->get("dbqb"));

        $latestThreads = $thread->findEvery(0, 3, "published");
        $allTags = [];

        foreach ($latestThreads as $currentThread) {
            $allTags[$currentThread->thisID] = $threadTag->findTags($currentThread->thisID);
        }

        $page->add("anax/publik/index", [
            "latestThreads" => $latestThreads,
            "tags" => $allTags,
            "popularTags" => $tags,
            "users" => $users
        ]);

        return $page->render([
            "title" => $title,
        ]);
    }


    /**
     * Display the input field for IP address.
     *
     * @return object
     */
    public function tradarActionGet() : object
    {
        $title = "Trådar";
        $di = $this->di;

        $request = $di->get("request");

        // Get params
        // -1 because $currentPage * $recordsPerPage
        $currentPage = $request->getGet("page") ? $request->getGet("page") - 1 : 0;
        $order = $request->getGet("order") ? $request->getGet("order") : "published";

        $thread = new Thread();
        $thread->setDb($di->get("dbqb"));

        // Init ThreadTag
        $threadTag = new ThreadTag();
        $threadTag->setDb($this->di->get("dbqb"));

        // For pagination
        $nrOfRecords = sizeof($thread->findAll());
        $recordsPerPage = 5;
        $pages = ceil($nrOfRecords/$recordsPerPage);
        $startingRecord = $currentPage * $recordsPerPage;

        $threads = $thread->findEvery($startingRecord, $recordsPerPage, $order);

        $request = $di->get("request");
        $page = $di->get("page");
        $allTags = [];

        foreach ($threads as $currentThread) {
            $allTags[$currentThread->thisID] = $threadTag->findTags($currentThread->thisID);
        }

        $page->add("anax/publik/tradar", [
            "threads" => $threads,
            "tags" => $allTags,
            "pages" => $pages,
            "currentPage" => $currentPage + 1,
            "order" => $order
        ]);

        return $page->render([
            "title" => $title,
        ]);
    }


    /**
     * Display the input field for IP address.
     *
     * @return object
     */
    public function usersActionGet() : object
    {
        $title = "Användare";
        $di = $this->di;
        $page = $di->get("page");

        $page->add("anax/publik/users", [
        ]);

        return $page->render([
            "title" => $title,
        ]);
    }


    /**
     * Display the input field for IP address.
     *
     * @return object
     */
    public function taggarActionGet() : object
    {
        $title = "Taggar";
        $di = $this->di;

        $tag = new Tag();
        $tag->setDb($di->get("dbqb"));
        $tags = $tag->findWithCount(1000);

        $page = $di->get("page");
        $page->add("anax/publik/taggar", [
            "tags" => $tags
        ]);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * Display the input field for IP address.
     *
     * @return object
     */
    public function tagActionGet($tagName) : object
    {
        $title = "Taggar";
        $di = $this->di;

        $tag = new Tag();
        $tag->setDb($di->get("dbqb"));
        $tag->findWhere("name = ?", $tagName);

        $threadTag = new ThreadTag();
        $threadTag->setDb($di->get("dbqb"));
        $threadIds = $threadTag->findAllWhere("tag_id = ?", $tag->id);

        $thread = new Thread();
        $thread->setDb($di->get("dbqb"));

        $page = $di->get("page");

        $threads = [];
        $query = "";
        $params = [];
        $allTags = [];
        $threads = [];

        if (sizeof($threadIds) !== 0) {
            foreach ($threadIds as $threadId) {
                $query .= "id = ? or ";
                array_push($params, $threadId->thread_id);
                $allTags[$threadId->thread_id] = $threadTag->findTags($threadId->thread_id);
            }

            $threads = $thread->findWithID(substr($query, 0, -4), $params);
        }


        $page->add("anax/publik/tag", [
            "threadTags" => $threadIds,
            "thread" => $thread,
            "tag" => $tagName,
            "threads" => $threads,
            "allTags" => $allTags
        ]);

        return $page->render([
            "title" => $title,
        ]);
    }

    public function threadAction($id) : object
    {
        $di = $this->di;
        $request = $di->get("request");

        // Fetch Get params
        $order = $request->getGet("order") ? $request->getGet("order") : "score";

        // Check if user is logged in
        $userLoggedIn = $di->get("session")->has("user");

        // Init Thread object
        $thread = new Thread();
        $thread->setDb($di->get("dbqb"));
        $thread->findWhere("id = ?", $id);

        // Init Comment object
        $comment = new Comment();
        $comment->setDb($di->get("dbqb"));
        $threadComments = $comment->findAllWhere("threadID = ?", $thread->id);

        // Init Answer object
        $answer = new Answer();
        $answer->setDb($di->get("dbqb"));

        // Answer form
        $answerForm = new CreateAnswerForm($this->di, $id);
        $answerForm->check();

        // Comment form
        $commentForm = new CreateCommentForm($this->di, $id);
        $commentForm->check();

        // Get the tags
        $threadTag = new ThreadTag();
        $threadTag->setDb($di->get("dbqb"));
        $tag = new Tag();
        $tag->setDb($di->get("dbqb"));
        $allThreadTags = $threadTag->findAllWhere("thread_id = ?", $id);

        // Creates the DB query
        $query = "";
        $tagsId = [];
        $tagsWithName = [];

        if (sizeof($allThreadTags) !== 0) {
            // Go get the tag-names
            foreach ($allThreadTags as $threadTag) {
                $query .= "id = ? or ";
                array_push($tagsId, $threadTag->tag_id);
            }
            $tagsWithName = $tag->findAllWhere(substr($query, 0, -4), $tagsId);
        }

        $page = $di->get("page");

        $page->add("anax/publik/thread", [
            "thread" => $thread,
            "tags" => $tagsWithName,
            "answerForm" => $answerForm->getHTML(),
            "answers" => $answer->findByOrder($order, $id),
            "userLoggedIn" => $userLoggedIn,
            "commentForm" => $commentForm->getHTML(),
            "commentObject" => $comment,
            "threadComments" => $threadComments,
            "order" => $order
        ]);

        $title = $thread->title;

        return $page->render([
            "title" => $title,
        ]);
    }
}
