<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\User;
use Authorization\IdentityInterface;
use Cake\Datasource\ModelAwareTrait;
use Throwable;

abstract class AbstractPolicy
{
    use ModelAwareTrait;

    /**
     * undocumented function
     *
     * @param \Authorization\IdentityInterface $user User
     * @return bool
     */
    protected function _isUserOnline(IdentityInterface $user): bool
    {
        $this->loadModel('Feeds');

        $feed = [];

        // Admins can always trigger actions
        if ($user->role === User::ROLE_ADMIN) {
            return true;
        }

        try {
            $feed = $this->Feeds->find()
                ->order(['created' => 'DESC'])
                ->firstOrFail()
                ->toArray();
        } catch (Throwable $t) {
            return false;
        }

        if (!empty($feed['data']['controllers'])) {
            foreach ($feed['data']['controllers'] as $controller) {
                if ((string)$controller['vatsim_id'] === $user->vatsim_id) {
                    return true;
                }
            }
        }

        return false;
    }
}
