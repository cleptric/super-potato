<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Airport;
use Authorization\IdentityInterface;
use Cake\I18n\FrozenTime;

class AirportPolicy extends AbstractPolicy
{
    /**
     * @param \Authorization\IdentityInterface $user User
     * @param \App\Model\Entity\Airport $airport Airport
     * @return bool
     */
    public function canUpdateMissedApproach(IdentityInterface $user, Airport $airport): bool
    {
        $userOnline = parent::_isUserOnline($user);

        if ($userOnline === false) {
            return false;
        }

        return !($airport->missed_approach_timeout > new FrozenTime());
    }

    /**
     * @param \Authorization\IdentityInterface $user User
     * @param \App\Model\Entity\Airport $airport Airport
     * @return bool
     */
    public function canUpdateRunwayClosed(IdentityInterface $user, Airport $airport): bool
    {
        $userOnline = parent::_isUserOnline($user);

        if ($userOnline === false) {
            return false;
        }

        return !($airport->closed_runways_timeout > new FrozenTime());
    }

    /**
     * @param \Authorization\IdentityInterface $user User
     * @param \App\Model\Entity\Airport $airport Airport
     * @return bool
     */
    public function canUpdateVisualDepature(IdentityInterface $user, Airport $airport): bool
    {
        return parent::_isUserOnline($user);
    }
}
