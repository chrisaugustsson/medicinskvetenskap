<?php

namespace Anax\User\HTMLForm;

use Anax\HTMLForm\FormModel;
use Anax\User\User;
use Psr\Container\ContainerInterface;

/**
 * Example of FormModel implementation.
 */
class UserUpdateForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di)
    {
        parent::__construct($di);

        $userName = $this->di->get("session")->get("user");
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->find("acronym", $userName);

        $this->form->create(
            [
                "id" => __CLASS__,
            ],
            [
                "Förnamn" => [
                    "type"      => "text",
                    "validation" => ["not_empty"],
                    "value" => $user->firstName
                ],

                "Efternamn" => [
                    "type"      => "text",
                    "validation" => ["not_empty"],
                    "value" => $user->lastName,
                ],

                "Email" => [
                    "type"         => "text",
                    "validation" => ["not_empty"],
                    "value" => $user->email
                ],

                "Gravatar-email" => [
                    "type"         => "text",
                    "validation" => ["not_empty"],
                ],

                "Befintligt-lösenord" => [
                    "type"        => "password",
                    "validation" => ["not_empty"],
                ],

                "Nytt-lösenord" => [
                    "type"        => "password",
                ],

                "Nytt-lösenord-igen" => [
                    "type"        => "password",
                    "validation" => [
                        "match" => "Nytt-lösenord",
                    ],
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Create user",
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
        $userName = $this->di->get("session")->get("user");
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->find("acronym", $userName);

        // Get values from the submitted form
        $acronym          = $user->acronym;
        $password         = $this->form->value("Befintligt-lösenord");
        $newPassword      = $this->form->value("Nytt-lösenord");
        $newPasswordAgain = $this->form->value("Nytt-lösenord-igen");
        $firstName        = $this->form->value("Förnamn");
        $lastName         = $this->form->value("Efternamn");
        $email            = $this->form->value("Email");
        $gravatar         = $this->form->value("Gravatar-email");

        $res = $user->verifyPassword($acronym, $password);

        if (!$res) {
            $this->form->rememberValues();
            $this->form->addOutput("Fel lösenord.");
            return false;
        }

        // Check password matches
        if ($newPassword !== $newPasswordAgain) {
            $this->form->rememberValues();
            $this->form->addOutput("Nytt lösenord matchade inte.");
            return false;
        }

        $user->acronym = $acronym;
        $user->firstName = $firstName;
        $user->lastName = $lastName;
        $user->email = $email;
        $user->gravatar = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($gravatar))) . "?d=" . urlencode("mp") . "&s=";
        $user->setPassword($password);

        if ($newPassword !== "") {
            $user->setPassword($newPassword);
        }

        $user->save();

        $this->form->addOutput("User was created.");
        return true;
    }
}
