<?php
declare(strict_types=1);

namespace App\Service\Data;

use App\Model\Entity\Airport;
use Cake\Datasource\ModelAwareTrait;

/**
 * @property \App\Model\Table\TafTable $Taf
 */
class TafDataService
{
    use ModelAwareTrait;

    /**
     * @var \App\Model\Entity\Airport
     */
    protected ?Airport $_airport;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->loadModel('Taf');
    }

    /**
     * @return string|null
     */
    public function getData(): ?string
    {
        $taf = $this->Taf->find()
            ->order(['created' => 'DESC'])
            ->first();

        return $taf->data[$this->_airport->icao] ?? null;
    }

    /**
     * @param \App\Model\EntityAirport $airport Airport
     * @return void
     */
    public function setAirport(Airport $airport): void
    {
        $this->_airport = $airport;
    }
}
