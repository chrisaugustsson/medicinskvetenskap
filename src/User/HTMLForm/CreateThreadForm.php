<?php

namespace Anax\User\HTMLForm;

use Anax\HTMLForm\FormModel;
use Anax\Thread\Thread;
use Anax\Tag\Tag;
use Anax\ThreadTag\ThreadTag;
use Psr\Container\ContainerInterface;

/**
 * Example of FormModel implementation.
 */
class CreateThreadForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di)
    {
        parent::__construct($di);

        $options = $this->getTags();

        $this->form->create(
            [
                "id" => __CLASS__,
            ],
            [
                "Titel" => [
                    "type"      => "text",
                    "validation" => ["not_empty"],
                ],

                "Innehåll" => [
                    "type"      => "textarea",
                    "validation" => ["not_empty"],
                ],

                "Tagg-1" => [
                    "type"      => "select",
                    "options" => $options
                ],

                "Tagg-2" => [
                    "type"      => "select",
                    "options" => $options
                ],

                "Tagg-3" => [
                    "type"      => "select",
                    "options" => $options
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Skapa tråd",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }


    /**
     * Get all tags
     *
     *
     * @return array $options with all the tags
     */
    public function getTags()
    {
        $tag = new Tag();
        $tag->setDb($this->di->get("dbqb"));
        $tags = $tag->findAll();
        $options = ["empty" => "ingen tag"];


        foreach ($tags as $tag) {
            $options[$tag->id] = $tag->name;
        }

        return $options;
    }

    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function callbackSubmit()
    {
        $response = $this->di->get("response");

        // Get values from the submitted form
        $title         = $this->form->value("Titel");
        $content       = $this->form->value("Innehåll");
        $tag1          = $this->form->value("Tagg-1");
        $tag2          = $this->form->value("Tagg-2");
        $tag3          = $this->form->value("Tagg-3");
        $owner         = $this->di->get("session")->get("user");



        // Package all tags for easier handling
        $tags = array_unique([$tag1, $tag2, $tag3]);

        // Filter markdown text
        $filter = $this->di->get("textfilter");
        $filteredContent = $filter->doFilter($content, "markdown");

        $thread = new Thread();
        $thread->setDb($this->di->get("dbqb"));

        $thread->title = $title;
        $thread->content = $filteredContent;
        $thread->owner = $owner;
        $thread->score = 0;

        $thread->save();

        // Get the id for the thread
        $db = $this->di->get("dbqb");
        $threadId = $db->lastInsertId();

        // Add tags
        foreach ($tags as $currentTag) {
            if ($currentTag !== "empty") {
                $threadTag = new ThreadTag();
                $threadTag->setDb($this->di->get("dbqb"));

                $threadTag->thread_id = $threadId;
                $threadTag->tag_id = $currentTag;
                $threadTag->save();
            }
        }

        $response->redirect("thread/" . $threadId);
    }
}
