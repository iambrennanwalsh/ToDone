<?php

namespace App\Mailer;

use App\Mailer\Mailer;
use App\Entity\Submission;
use App\Entity\User;

/**
 * This class defines a function for every email sent to the admin.
 *
 * @author Brennan Walsh
 * @email mail@brennanwal.sh
 * @github https://github.com/iambrennanwalsh
 */
class AdminMailer extends Mailer
{
    public function newUser(User $user)
    {
        $this->setSubject("A new ToDone user has registered.");
        $this->setTemplate("util/email/admin/new-user.twig");
        $this->setContent(["user" => $user]);
        return $this->send();
    }

    public function accountClosed(User $user)
    {
        $this->setSubject("A user has closed their account.");
        $this->setTemplate("util/email/admin/account-closed.twig");
        $this->setContent(["user" => $user]);
        return $this->send();
    }

    public function contactFormSubmission(Submission $submission)
    {
        $this->setSubject(
            "We've recieved a new ToDone contact form submission."
        );
        $this->setTemplate("util/email/admin/contact-form-submission.twig");
        $this->setContent(["submission" => $submission]);
        return $this->send();
    }
}
