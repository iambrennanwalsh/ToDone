<?php

namespace App\Mailer;

use App\Mailer\Mailer;
use App\Entity\User;

/**
 * This class defines a function for every email sent to a user.
 *
 * @author Brennan Walsh
 * @email mail@brennanwal.sh
 * @github https://github.com/iambrennanwalsh
 */
class UserMailer extends Mailer
{
    public function confirmEmail(User $user)
    {
        $this->setSubject("Please confirm your email.");
        $this->setTemplate("util/email/user/confirm-email.twig");
        $this->setContent(["user" => $user]);
        $this->setTo($user->getEmail());
        return $this->send();
    }

    public function welcome(User $user)
    {
        $this->setSubject("Welcome to ToDone.");
        $this->setTemplate("util/email/user/welcome.twig");
        $this->setContent(["user" => $user]);
        $this->setTo($user->getEmail());
        return $this->send();
    }

    public function passwordChanged(User $user)
    {
        $this->setSubject("Your ToDone password has been changed.");
        $this->setTemplate("util/email/user/password-changed.twig");
        $this->setContent(["user" => $user]);
        $this->setTo($user->getEmail());
        return $this->send();
    }

    public function resetPassword(User $user)
    {
        $this->setSubject("Reset your ToDone password.");
        $this->setTemplate("util/email/user/reset-password.twig");
        $this->setContent(["user" => $user]);
        $this->setTo($user->getEmail());
        return $this->send();
    }

    public function closedAccount(User $user)
    {
        $this->setSubject("Your ToDone account has been closed.");
        $this->setTemplate("util/email/user/closed-account.twig");
        $this->setContent(["user" => $user]);
        $this->setTo($user->getEmail());
        return $this->send();
    }
}
