<?php
declare(strict_types=1);

namespace App\Service\Data;

use Authorization\IdentityInterface;
use Cake\Datasource\ModelAwareTrait;

class NotificationsDataService
{
    use ModelAwareTrait;

    protected ?IdentityInterface $_user;

    public function __construct()
    {
        $this->loadModel('Users');
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
