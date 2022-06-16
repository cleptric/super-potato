<?php
declare(strict_types=1);

namespace App\Service\Data;

use App\Model\Entity\Airport;
use Cake\Datasource\ModelAwareTrait;

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

        return $taf->data[$this->_airport->icao]['raw_text'] ?? null;
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
