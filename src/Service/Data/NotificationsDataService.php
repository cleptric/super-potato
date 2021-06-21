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
                'loww' => filter_var($data['loww'], FILTER_VALIDATE_BOOLEAN),
                'lowi' => filter_var($data['lowi'], FILTER_VALIDATE_BOOLEAN),
                'lows' => filter_var($data['lows'], FILTER_VALIDATE_BOOLEAN),
                'lowg' => filter_var($data['lowg'], FILTER_VALIDATE_BOOLEAN),
                'lowk' => filter_var($data['lowk'], FILTER_VALIDATE_BOOLEAN),
                'lowl' => filter_var($data['lowl'], FILTER_VALIDATE_BOOLEAN),
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
