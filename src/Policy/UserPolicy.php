<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\User;
use Authorization\IdentityInterface;

class UserPolicy extends AbstractPolicy
{
    public function canTriggerActions(IdentityInterface $identityUser, User $user): bool
    {
        return parent::_isUserOnline($identityUser);
    }
}
