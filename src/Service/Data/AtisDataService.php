<?php
declare(strict_types=1);

namespace App\Service\Data;

use App\Model\Entity\Airport;
use App\Model\Entity\Atis;
use Cake\Datasource\ModelAwareTrait;

/**
 * @property \App\Model\Table\AtisTable $Atis
 */
class AtisDataService
{
    use ModelAwareTrait;

    /**
     * @var \App\Model\Entity\Airport|null
     */
    protected ?Airport $_airport;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->loadModel('Atis');
    }

    /**
     * @return \App\Model\Entity\Atis|null
     */
    public function getData(): ?Atis
    {
        return $this->Atis->find()
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
