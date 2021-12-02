<?php
declare(strict_types=1);

namespace App\Service\Data;

use App\Service\LogsService;
use Authorization\IdentityInterface;
use Cake\Datasource\ModelAwareTrait;
use Throwable;

class MainDataService
{
    use ModelAwareTrait;

    protected ?array $_feed = null;

    protected ?array $_metar = null;

    protected ?array $_taf = null;

    protected ?IdentityInterface $_user;

    public function __construct()
    {
        $this->loadModel('Feeds');
        $this->loadModel('Metar');
        $this->loadModel('Taf');

        try {
            $this->_feed = $this->Feeds->find()
                ->order(['created' => 'DESC'])
                ->firstOrFail()
                ->toArray();
        } catch (Throwable $t) {
        }

        try {
            $this->_metar = $this->Metar->find()
                ->order(['created' => 'DESC'])
                ->firstOrFail()
                ->toArray();
        } catch (Throwable $t) {
        }

        try {
            $this->_taf = $this->Taf->find()
                ->order(['created' => 'DESC'])
                ->firstOrFail()
                ->toArray();
        } catch (Throwable $t) {
        }
    }

    public function getData(): array
    {
        return [
            'user' => [
                'name' => $this->_user->full_name,
                'vatsim_id' => $this->_user->vatsim_id,
                'can_trigger_actions' => $this->_user->can('triggerActions', $this->_user),
                'onboarded' => $this->_user->onboarded,
            ],
            'logs' => (new LogsService())->getData(),
            'eddm' => (new EddmDataService($this->_feed, $this->_metar, $this->_taf))->getData(),
        ];
    }

    public function setUser(IdentityInterface $user): void
    {
        $this->_user = $user;
    }
}
