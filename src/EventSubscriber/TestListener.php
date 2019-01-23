<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TestListener implements EventSubscriberInterface {

	public static function getSubscribedEvents() {
		
		return array(
			'event.finna' => 'runCode'
		); 
	}
	
	public function runCode() {
		// 
	}
	
}