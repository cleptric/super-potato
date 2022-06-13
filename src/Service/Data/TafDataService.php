<?php
declare(strict_types=1);

namespace App\Service\Data;

use App\Model\Entity\Airport;
use Cake\Datasource\ModelAwareTrait;

class TafDataService
{
    use ModelAwareTrait;

    protected ?Airport $_airport;

    public function __construct()
    {
        $this->loadModel('Taf');
    }

    public function getData(): ?string
    {
        $taf = $this->Taf->find()
            ->order(['created' => 'DESC'])
            ->first();

        return $taf->data[$this->_airport->icao]['raw_text'] ?? null;
    }

    public function setAirport(Airport $airport)
    {
        $this->_airport = $airport;
    }
}
