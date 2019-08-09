<?php

namespace App\Doctrine;

use Doctrine\ORM\Events;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use App\Entity\User;
use App\Mailer\UserMailer;
use App\Mailer\AdminMailer;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * This doctrine event subscriber subscribes to the preUpdate and prePersist events on the Users class.
 * See https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/events.html.
 *
 * @author Brennan Walsh <mail@brennanwal.sh>
 */
class UserSubscriber implements EventSubscriber
{
    private $token;
    private $encoder;
    private $userMailer;
    private $adminMailer;

    public function __construct(
        TokenStorageInterface $token,
        UserPasswordEncoderInterface $encoder,
        UserMailer $userMailer,
        AdminMailer $adminMailer
    ) {
        $this->token = $token;
        $this->encoder = $encoder;
        $this->userMailer = $userMailer;
        $this->adminMailer = $adminMailer;
    }

    public function getSubscribedEvents()
    {
        return array(Events::preUpdate, Events::prePersist, Events::preRemove);
    }

    /**
     * If a User is being persisted, then registration just happened. Encode the password and send out emails.
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        // If entity being persisted is a User.. then registration just happened.
        if ($entity instanceof User) {
            // Encode and set password.
            if ($entity->getPassword()) {
                $password = $this->encoder->encodePassword(
                    $entity,
                    $entity->getPassword()
                );
                $entity->setPassword($password);
            }

            // Send out emails.
            $this->adminMailer->newUser($entity);
            $this->userMailer->welcome($entity);
            $this->userMailer->confirmEmail($entity);
        }
    }

    /**
     * If a User is being updated, check if the email or password has changed.
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        // Check if entity being updated is a User.
        if ($entity instanceof User) {
            // If the user updated their password, encode and update it.
            if ($args->hasChangedField('password')) {
                $password = $this->encoder->encodePassword(
                    $entity,
                    $args->getNewValue('password')
                );
                $entity->setPassword($password);
                $this->userMailer->passwordChanged($entity);
            }

            // If the user updated their email, send out email, and update confirmed status.
            if ($args->hasChangedField('email')) {
                $this->userMailer->confirmEmail($entity);
                $entity->setConfirmed(false);
            }
        }
    }

    /**
     * If a User is being deleted, send them one last email confirming the deletion.
     */
    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof User) {
            $this->userMailer->closedAccount($entity);
            $this->adminMailer->accountClosed($entity);
            $this->token->setToken(null);
        }
    }
}
