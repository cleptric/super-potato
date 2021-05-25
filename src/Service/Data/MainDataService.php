<?php
declare(strict_types=1);

namespace App\Service\Data;

use App\Service\Atis\LowwDecoderService;
use App\Service\Data\LowwDataService;
use App\Service\Data\LowiDataService;
use App\Service\Metar\MetarDecoderService;
use App\Service\WindComponent\LowwWindComponentService;
use Authentication\Identity;
use Cake\Datasource\ModelAwareTrait;
use Throwable;

class MainDataService
{
    use ModelAwareTrait;

    protected ?array $_feed = null;

    protected ?array $_metar = null;

    protected ?Identity $_user;

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
            ],
            'loww' => (new LowwDataService($this->_feed, $this->_metar))->getData(),
            'lowi' => (new LowiDataService($this->_feed, $this->_metar))->getData(),
        ];
    }

    public function setUser(Identity $user): void
    {
        $this->_user = $user;
    }
}