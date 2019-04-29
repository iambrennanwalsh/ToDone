<?php

namespace App\Security;

use App\Entity\Boards;
use App\Entity\Users;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class BoardsVoter extends Voter {
	
	
    const VIEW = 'view';
	
	
    protected function supports($attribute, $subject) {
        if (!in_array($attribute, array(self::VIEW))) {
            return false;}
        if (!$subject instanceof Boards) {
            return false;}
        return true;}
	
	
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token) {
        $user = $token->getUser();
        if (!$user instanceof Users) {
            return false;}
        $board = $subject;
        switch ($attribute) {
            case self::VIEW:
                return $this->canView($board, $user);}
        throw new \LogicException('This code should not be reached!');}
	
	
    private function canView(Boards $board, Users $user) {
			return $user === $board->getUserid();}
	
}