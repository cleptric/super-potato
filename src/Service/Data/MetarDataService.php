<?php
declare(strict_types=1);

namespace App\Service\Data;

use App\Model\Entity\Airport;
use App\Model\Entity\Metar;
use Cake\Datasource\ModelAwareTrait;

/**
 * @property \App\Model\Table\MetarTable $Metar
 */
class MetarDataService
{
    use ModelAwareTrait;

    protected ?Airport $_airport;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->loadModel('Metar');
    }

    /**
     * @return \App\Model\Entity\Metar|null
     */
    public function getData(): ?Metar
    {
        return $this->Metar->find()
            ->where(['airport_id' => $this->_airport->id])
            ->order(['created' => 'DESC'])
            ->first();
    }

    /**
     * @param \App\Model\Entity\Airport $airport Airport
     * @return void
     */
    public function setAirport(Airport $airport): void
    {
        $this->_airport = $airport;
    }
}
