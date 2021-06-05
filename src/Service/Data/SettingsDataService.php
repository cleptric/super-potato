<?php
declare(strict_types=1);

namespace App\Service\Data;

use Authorization\IdentityInterface;
use App\Service\Data\LowiDataService;
use App\Service\Data\LowgDataService;
use App\Service\Data\LowkDataService;
use App\Service\Data\LowlDataService;
use App\Service\Data\LowsDataService;
use App\Service\Data\LowwDataService;
use App\Service\LogsService;
use App\Service\Metar\MetarDecoderService;
use App\Service\WindComponent\LowwWindComponentService;
use Cake\Datasource\ModelAwareTrait;
use Throwable;

class SettingsDataService
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

    public function getData(): ?array
    {
        $user = $this->Users->get($this->_user->id);

        return [
            'settings' => $user->settings,
        ];
    }

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

    public function setUser(IdentityInterface $user): void
    {
        $this->_user = $user;
    }
}