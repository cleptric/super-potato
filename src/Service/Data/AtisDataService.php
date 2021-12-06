<?php
declare(strict_types=1);

namespace App\Service\Data;

use App\Model\Entity\Airport;
use App\Model\Entity\Atis;
use App\Service\Metar\MetarDecoderService;
use Cake\Datasource\ModelAwareTrait;

class AtisDataService
{
    use ModelAwareTrait;

    protected ?Airport $_airport;

    public function __construct()
    {
        $this->loadModel('Atis');
    }

    public function getData(): ?Atis
    {
        return $this->Atis->find()
            ->where(['airport_id' => $this->_airport->id])
            ->order(['created' => 'DESC'])
            ->first();
    }

    public function setAirport(Airport $airport)
    {
        $this->_airport = $airport;
    }
}