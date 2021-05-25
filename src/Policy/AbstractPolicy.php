<?php
declare(strict_types=1);

namespace App\Policy;

use Authorization\IdentityInterface;
use Cake\Datasource\ModelAwareTrait;
use Throwable;

abstract class AbstractPolicy
{

    use ModelAwareTrait;

    protected function _isUserOnline(IdentityInterface $user): bool
    {
        $this->loadModel('Feeds');

        $feed = [];

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
