<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\User;
use Authorization\IdentityInterface;

class UserPolicy extends AbstractPolicy
{
    /**
     * @param \Authorization\IdentityInterface $identityUser User
     * @return bool
     */
    public function canTriggerActions(IdentityInterface $identityUser): bool
    {
        return parent::_isUserOnline($identityUser);
    }

    /**
     * @param \Authorization\IdentityInterface $identityUser User
     * @return bool
     */
    public function canAccessAdmin(IdentityInterface $identityUser): bool
    {
        if ($identityUser->role === User::ROLE_ADMIN) {
            return true;
        }

        return false;
    }
}
