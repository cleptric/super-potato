<?php
declare(strict_types=1);

namespace App\Service\Vatsim;

use Cake\Datasource\ModelAwareTrait;
use Cake\Http\Client;

class MetarService
{

    use ModelAwareTrait;

    /**
     * @var string
     */
    protected string $_vatsimStatusUrl = 'https://status.vatsim.net/status.json';

    public function fetchMetar(string $icao)
    {
        $metarUrl = $this->_getMetarUrl();

        $client = new Client();
        $response = $client->get($metarUrl, [
            'id' => $icao,
        ]);
        $responseBody = $response->getStringBody();

        return $responseBody;
    }

    protected function _getMetarUrl():string
    {
        $client = new Client();
        $response = $client->get($this->_vatsimStatusUrl);
        $responseBody = json_decode($response->getStringBody(), true);

        return $responseBody['metar'][0];
    }
}