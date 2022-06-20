<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\Entity\User;
use Authentication\IdentityInterface;
use Cake\Collection\CollectionInterface;
use Cake\Datasource\ModelAwareTrait;
use Cake\Http\Exception\BadRequestException;

/**
 * @property \App\Model\Table\UsersTable $Users
 * @property \Cake\ORM\Table $Sessions
 */
class AdminService
{
    use ModelAwareTrait;

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
        $this->loadModel('Sessions');
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        $users = $this->Users->find()
            ->order(['full_name' => 'ASC'])
            ->formatResults(function (CollectionInterface $users) {
                return $users->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'full_name' => $user->full_name,
                        'vatsim_id' => $user->vatsim_id,
                        'status' => $user->status,
                        'role' => $user->role,
                    ];
                });
            })
            ->toArray();

        return [
            'users' => $users,
        ];
    }

    /**
     * @param array<string, mixed> $data Data
     * @return void
     */
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

    /**
     * @param array<string, mixed> $data Data
     * @return void
     */
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

    /**
     * @param \Authentication\IdentityInterface|null $user User
     * @return void
     */
    public function setUser(?IdentityInterface $user): void
    {
        $this->_user = $user;
    }
}
