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

class MainDataService
{
    use ModelAwareTrait;

    protected ?array $_feed = null;

    protected ?array $_metar = null;

    protected ?IdentityInterface $_user;

    public function __construct()
    {
        $this->loadModel('Feeds');
        $this->loadModel('Metar');

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
    }

    public function getData(): array
    {
        return [
            'user' => [
                'id' => $this->_user->id,
                'name' => $this->_user->full_name,
                'vatsim_id' => $this->_user->vatsim_id,
                'can_trigger_actions' => $this->_user->can('triggerActions', $this->_user),
                'online_as' => null,
            ],
            'logs' => (new LogsService())->getData(),
            'loww' => (new LowwDataService($this->_feed, $this->_metar))->getData(),
            'lowi' => (new LowiDataService($this->_feed, $this->_metar))->getData(),
            'lows' => (new LowsDataService($this->_feed, $this->_metar))->getData(),
            'lowg' => (new LowgDataService($this->_feed, $this->_metar))->getData(),
            'lowk' => (new LowkDataService($this->_feed, $this->_metar))->getData(),
            'lowl' => (new LowlDataService($this->_feed, $this->_metar))->getData(),
        ];
    }

    public function setUser(IdentityInterface $user): void
    {
        $this->_user = $user;
    }
}