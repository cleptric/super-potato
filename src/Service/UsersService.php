<?php
declare(strict_types=1);

namespace App\Service;

use Authorization\IdentityInterface;
use Cake\Datasource\ModelAwareTrait;
use Throwable;

class UsersService
{
    use ModelAwareTrait;

    protected ?array $_settings = null;

    protected ?IdentityInterface $_user;

    public function __construct()
    {
        $this->loadModel('Users');

        try {
            $this->_settings = $this->Users->find()
                ->select('settings')
                ->where(['id' => $this->_user->id])
                ->firstOrFail()
                ->toArray();
        } catch (Throwable $t) {
        }
    }

    public function deleteAccount(): void
    {
        $user = $this->Users->get($this->_user->id);
        $user = $this->Users->delete($user);
    }

    public function setUser(IdentityInterface $user): void
    {
        $this->_user = $user;
    }
}
