<?php
declare(strict_types=1);

namespace App\Service\Vatsim;

use Cake\Datasource\ModelAwareTrait;
use Cake\Http\Client;

class DataFeedService
{

    use ModelAwareTrait;

    /**
     * @var string
     */
    protected string $_vatsimStatusUrl = 'https://status.vatsim.net/status.json';

    /**
     * @var string
     */
    protected string $_vatsimFeedVersion = 'v3';

    public function __contruct()
    {
        // $this->loadModel('DataFeed');
    }

    public function fetchFeed()
    {
        $feedUrl = $this->_getFeedUrl();

        $client = new Client();
        $response = $client->get($feedUrl);
        $responseBody = json_decode($response->getStringBody(), true);

        /**
         * 1. Save the raw feed into the DB
         * 2. Parse the feed and save it into the DB
         */

        return $responseBody;
    }

    protected function _getFeedUrl():string
    {
        $client = new Client();
        $response = $client->get($this->_vatsimStatusUrl);
        $responseBody = json_decode($response->getStringBody(), true);

        return $responseBody['data'][$this->_vatsimFeedVersion][0];
    }

    protected function _parseFeed()
    {
    }
}