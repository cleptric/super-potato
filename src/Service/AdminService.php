<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\Entity\User;
use Authorization\IdentityInterface;
use Cake\Collection\CollectionInterface;
use Cake\Datasource\ModelAwareTrait;
use Cake\Http\Exception\BadRequestException;

class AdminService
{
    use ModelAwareTrait;

    protected ?IdentityInterface $_user;

    public function __construct()
    {
        $this->loadModel('Users');
        $this->loadModel('Sessions');
    }

    public function getData(): array
    {
        $users = $this->Users->find()
            ->order(['full_name' => 'DESC'])
            ->formatResults(function (CollectionInterface $users) {
                return $users->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'full_name' => $user->full_name,
                        'vatsim_id' => $user->vatsim_id,
                        'status' => $user->status,
                        'admin' => $user->admin,
                    ];
                });
            })
            ->toArray();

        return [
            'users' => $users,
        ];
    }

    public function blockUser(array $data): void
    {
        // Don't block yourself
        if ($this->_user->id === $data['user_id']) {
            throw new BadRequestException();
        }

        $user = $this->Users->get($data['user_id']);
        $user = $this->Users->patchEntity($user, [
            'status' => User::STATUS_BLOCKED,
        ], [
            'accessibleFields' => [
                'status' => true,
            ],
        ]);

        if ($this->Users->save($user) === false) {
            throw new BadRequestException();
        }

        // Delete all user sessions
        $query = $this->Sessions->find()
            ->where([
                ['data LIKE' => '%' . addslashes(User::class) . '%'],
                ['data LIKE' => '%' . $user->id . '%'],
            ]);

        if ($query->count() > 0) {
            $sessionIds = $query->extract('id')->toArray();
            $this->Sessions->deleteAll(['id IN' => $sessionIds]);
        }
    }

    public function unblockUser(array $data): void
    {
        $user = $this->Users->get($data['user_id']);
        $user = $this->Users->patchEntity($user, [
            'status' => User::STATUS_ACTIVE,
        ], [
            'accessibleFields' => [
                'status' => true,
            ],
        ]);

        if ($this->Users->save($user) === false) {
            throw new BadRequestException();
        }
    }

    public function setUser(IdentityInterface $user): void
    {
        $this->_user = $user;
    }
}
