<?php

namespace App\Doctrine;

use App\Entity\Users;
use Doctrine\ORM\Events;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use App\Security\EmailVerification;

class UpdateSubscriber implements EventSubscriber {
	
	private $verification; 
	
	public function __construct(EmailVerification $verification) {	
		$this->verification = $verification; }

	
  public function getSubscribedEvents() {
    return array(Events::preUpdate); }
	
	
  public function preUpdate(LifecycleEventArgs $args) {
  	$entity = $args->getObject();
    if ($entity instanceof Users && $args->hasChangedField('email')) {
			$this->verification->sendConfirmationEmail(); } }
} 
