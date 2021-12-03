<?php
declare(strict_types=1);

namespace App\Service;

use Authentication\PasswordHasher\DefaultPasswordHasher;
use Authorization\IdentityInterface;
use Cake\Datasource\ModelAwareTrait;
use Cake\Http\Exception\BadRequestException;
use Throwable;

class UserService
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

    public function changePassword(array $data): void
    {
        $user = $this->Users->get($this->_user->id);

        $passwordHasher = new DefaultPasswordHasher();
        if ($passwordHasher->check($data['current_password'], $user->password) === false) {
            throw new BadRequestException();
        }

        $user = $this->Users->patchEntity($user, [
            'password' => $data['new_password'],
        ], [
            'accessibleFields' => [
                'password' => true,
            ],
        ]);

        if ($this->Users->save($user) === false) {
            throw new BadRequestException();
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
