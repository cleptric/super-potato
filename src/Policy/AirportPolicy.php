<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Airport;
use Authorization\IdentityInterface;
use Cake\I18n\FrozenTime;

class AirportPolicy extends AbstractPolicy
{
    public function canUpdateMissedApporach(IdentityInterface $user, Airport $airport): bool
    {
        $userOnline = parent::_isUserOnline($user);

        if ($userOnline === false) {
            return false;
        }

        return !($airport->missed_approach_timeout > new FrozenTime());
    }

    public function canUpdateRunwayClosed(IdentityInterface $user, Airport $airport): bool
    {
        $userOnline = parent::_isUserOnline($user);

        if ($userOnline === false) {
            return false;
        }

        return !($airport->closed_runways_timeout > new FrozenTime());
    }

    public function canUpdateVisualDepature(IdentityInterface $user, Airport $airport): bool
    {
        return parent::_isUserOnline($user);
    }
}
