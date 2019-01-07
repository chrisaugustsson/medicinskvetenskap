<?php

namespace Anax\User\HTMLForm;

use Anax\HTMLForm\FormModel;
use Anax\User\User;
use Psr\Container\ContainerInterface;

/**
 * Example of FormModel implementation.
 */
class CreateUserForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di)
    {
        parent::__construct($di);
        $this->form->create(
            [
                "id" => __CLASS__,
            ],
            [
                "Förnamn" => [
                    "type"      => "text",
                    "validation" => ["not_empty"],
                ],

                "Efternamn" => [
                    "type"      => "text",
                    "validation" => ["not_empty"],
                ],

                "Användarnamn" => [
                    "type"        => "text",
                    "validation" => ["not_empty"],
                ],

                "Email" => [
                    "type"         => "text",
                    "validation" => ["not_empty"],
                ],

                "Gravatar-email" => [
                    "type"         => "text",
                    "validation" => ["not_empty"],
                ],

                "Lösenord" => [
                    "type"        => "password",
                    "validation" => ["not_empty"],
                ],

                "Lösenord-igen" => [
                    "type"        => "password",
                    "validation" => [
                        "match" => "Lösenord",
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
        // Get values from the submitted form
        $acronym       = $this->form->value("Användarnamn");
        $password      = $this->form->value("Lösenord");
        $passwordAgain = $this->form->value("Lösenord-igen");
        $firstName     = $this->form->value("Förnamn");
        $lastName      = $this->form->value("Efternamn");
        $email         = $this->form->value("Email");
        $gravatar      = $this->form->value("Gravatar-email");




        // Check password matches
        if ($password !== $passwordAgain) {
            $this->form->rememberValues();
            $this->form->addOutput("Password did not match.");
            return false;
        }

        if (preg_match('[\W]', $acronym)) {
            $this->form->rememberValues();
            $this->form->addOutput("Inga specialtecken tillåtna i användarnamn.");
            return false;
        }

        $user = new User();
        $user->setDb($this->di->get("dbqb"));

        // Check if usernamne already exists
        if (sizeof($user->findAllWhere("acronym = ?", $acronym)) === 1) {
            $this->form->rememberValues();
            $this->form->addOutput("Användarnamn finns redan.");
            return false;
        }

        $user->acronym = $acronym;
        $user->firstName = $firstName;
        $user->lastName = $lastName;
        $user->email = $email;
        $user->gravatar = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($gravatar))) . "?d=" . urlencode("mp") . "&s=";
        $user->setPassword($password);
        $user->save();

        $this->form->addOutput("User was created.");
        return true;
    }
}
