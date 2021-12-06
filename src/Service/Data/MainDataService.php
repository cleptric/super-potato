<?php
declare(strict_types=1);

namespace App\Service\Data;

use App\Service\LogsService;
use Authorization\IdentityInterface;
use Cake\Datasource\ModelAwareTrait;
use Throwable;

class MainDataService
{
    use ModelAwareTrait;

    /**
     * @var \Authorization\IdentityInterface|null
     */
    protected ?IdentityInterface $_user;

    public function getData(): array
    {
        return [
            'user' => [
                'name' => $this->_user->full_name,
                'vatsim_id' => $this->_user->vatsim_id,
                'can_trigger_actions' => $this->_user->can('triggerActions', $this->_user),
                'onboarded' => $this->_user->onboarded,
            ],
            'loww' => (new LowwDataService())->getData(),
            'logs' => (new LogsService())->getData(),
        ];
    }

    public function setUser(IdentityInterface $user): void
    {
        $this->_user = $user;
    }
}
