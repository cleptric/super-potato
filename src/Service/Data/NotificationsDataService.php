<?php
declare(strict_types=1);

namespace App\Service\Data;

use Authorization\IdentityInterface;
use Cake\Datasource\ModelAwareTrait;
use Throwable;

class NotificationsDataService
{
    use ModelAwareTrait;

    protected ?array $_settings = null;

    protected ?IdentityInterface $_user;

    public function __construct()
    {
        $this->loadModel('Users');

        try {
            $this->_settings = $this->Users->find()
                ->select('notifications')
                ->where(['id' => $this->_user->id])
                ->firstOrFail()
                ->toArray();
        } catch (Throwable $t) {
        }
    }

    public function getData(): ?array
    {
        $user = $this->Users->get($this->_user->id);

        return [
            'notifications' => $user->notifications,
        ];
    }

    public function saveData(array $data): void
    {
        $user = $this->Users->get($this->_user->id);
        $user = $this->Users->patchEntity($user, [
            'notifications' => [
                'eddm' => filter_var($data['eddm'], FILTER_VALIDATE_BOOLEAN),
            ],
        ], [
            'accessibleFields' => [
                'notifications' => true,
            ],
        ]);
        $this->Users->saveOrFail($user);
    }

    public function setUser(IdentityInterface $user): void
    {
        $this->_user = $user;
    }
}
