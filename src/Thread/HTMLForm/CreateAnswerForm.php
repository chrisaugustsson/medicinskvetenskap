<?php

namespace Anax\Thread\HTMLForm;

use Anax\HTMLForm\FormModel;
use Anax\Thread\Thread;
use Anax\Tag\Tag;
use Anax\ThreadTag\ThreadTag;
use Anax\Answer\Answer;
use Psr\Container\ContainerInterface;

/**
 * Example of FormModel implementation.
 */
class CreateAnswerForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, $threadId)
    {
        parent::__construct($di);

        $this->form->create(
            [
                "id" => __CLASS__,
            ],
            [
                "Svar" => [
                    "type"      => "textarea",
                    "validation" => ["not_empty"],
                ],

                "thread" => [
                    "type" => "hidden",
                    "value" => $threadId
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Skicka svar",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
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
        $content       = $this->form->value("Svar");
        $thread       = $this->form->value("thread");
        $owner         = $this->di->get("session")->get("user");


        // Filter markdown text
        $filter = $this->di->get("textfilter");
        $filteredContent = $filter->doFilter($content, "markdown");

        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));

        $answer->owner = $owner;
        $answer->content = $filteredContent;
        $answer->threadID = $thread;

        $answer->save();

        $response->redirect("thread/" . $thread);
    }
}
