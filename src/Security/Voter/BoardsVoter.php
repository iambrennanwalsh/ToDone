<?php

namespace App\Security\Voter;

use App\Entity\Board;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class BoardsVoter extends Voter
{
    const VIEW = 'view';

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, array(self::VIEW))) {
            return false;
        }
        if (!$subject instanceof Board) {
            return false;
        }
        return true;
    }

    protected function voteOnAttribute(
        $attribute,
        $subject,
        TokenInterface $token
    ) {
        $user = $token->getUser();
        if (!$user instanceof User) {
            return false;
        }
        $board = $subject;
        switch ($attribute) {
            case self::VIEW:
                return $this->canView($board, $user);
        }
        throw new \LogicException('This code should not be reached!');
    }

    private function canView(Board $board, User $user)
    {
        return $user === $board->getUserid();
    }
}
