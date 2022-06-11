<?php
declare(strict_types=1);

namespace App\Service\Data;

use App\Model\Entity\Airport;
use App\Model\Entity\Metar;
use Cake\Datasource\ModelAwareTrait;

class MetarDataService
{
    use ModelAwareTrait;

    protected ?Airport $_airport;

    public function __construct()
    {
        $this->loadModel('Metar');
    }

    public function getData(): ?Metar
    {
        return $this->Metar->find()
            ->where(['airport_id' => $this->_airport->id])
            ->order(['created' => 'DESC'])
            ->first();
    }

    public function setAirport(Airport $airport)
    {
        $this->_airport = $airport;
    }
}
