<?php
// src/Security/ListsVoter.php
namespace App\Security;

use App\Entity\Lists;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ListsVoter extends Voter
{
    const VIEW = 'view';
	
    protected function supports($attribute, $subject) {
        if (!in_array($attribute, array(self::VIEW))) {
            return false;}
        if (!$subject instanceof Lists) {
            return false;}
        return true;}
	
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token) {
        $user = $token->getUser();
        if (!$user instanceof User) {
            return false;}
        $lists = $subject;
        switch ($attribute) {
            case self::VIEW:
                return $this->canView($lists, $user);}
        throw new \LogicException('This code should not be reached!');}
	
    private function canView(Lists $lists, User $user) {
			return $user === $lists->getUserid();}
	
}