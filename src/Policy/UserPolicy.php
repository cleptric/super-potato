<?php
declare(strict_types=1);

namespace App\Policy;

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
}
