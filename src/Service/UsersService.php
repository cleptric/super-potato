<?php
declare(strict_types=1);

namespace App\Service;

use Authorization\IdentityInterface;
use Cake\Datasource\ModelAwareTrait;
use Throwable;

/**
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersService
{
    use ModelAwareTrait;

    /**
     * @var array<string, mixed>|null
     */
    protected ?array $_settings = null;

    /**
     * @var \Authorization\IdentityInterface|null
     */
    protected ?IdentityInterface $_user;

    /**
     * Constructor
     */
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

    /**
     * @param \Authorization\IdentityInterface $user User
     * @return void
     */
    public function setUser(IdentityInterface $user): void
    {
        $this->_user = $user;
    }

    /**
     * @return void
     */
    public function deleteAccount(): void
    {
        $user = $this->Users->get($this->_user->id);
        $user = $this->Users->delete($user);
    }
}
