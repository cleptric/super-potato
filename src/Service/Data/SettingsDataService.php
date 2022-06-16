<?php
declare(strict_types=1);

namespace App\Service\Data;

use Authorization\IdentityInterface;
use Cake\Datasource\ModelAwareTrait;
use Throwable;

class SettingsDataService
{
    use ModelAwareTrait;

    /**
     * @var array<string, mixed>|null
     */
    protected ?array $_settings = null;

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
     * @return array|null
     */
    public function getData(): ?array
    {
        $user = $this->Users->get($this->_user->id);

        return [
            'settings' => $user->settings,
        ];
    }

    /**
     * @param array $data Data
     * @return void
     */
    public function saveData(array $data): void
    {
        $user = $this->Users->get($this->_user->id);
        $user = $this->Users->patchEntity($user, [
            'settings' => [
                'notifications' => filter_var($data['notifications'], FILTER_VALIDATE_BOOLEAN),
                'sounds' => filter_var($data['sounds'], FILTER_VALIDATE_BOOLEAN),
                'volume' => $data['volume'],
            ],
        ], [
            'accessibleFields' => [
                'settings' => true,
            ],
        ]);
        $this->Users->saveOrFail($user);
    }

    /**
     * @param \Authorization\IdentityInterface $user User
     * @return void
     */
    public function setUser(IdentityInterface $user): void
    {
        $this->_user = $user;
    }
}
