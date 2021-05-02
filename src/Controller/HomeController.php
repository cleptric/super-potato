<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\Vatsim\DataFeedService;
use App\Service\Vatsim\MetarService;
use App\Service\Vatsim\MetarDecoderService;
use App\Service\Vatsim\Atis\LowsDecoderService;
use App\Service\Vatsim\Atis\LowwDecoderService;

class HomeController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        // $feedService = new DataFeedService();
        // $feed = $feedService->fetchFeed();

        $atisService = new LowwDecoderService();
        $atisService->setDataFeed();
        $atisLoww = $atisService->getData();

        $atisService = new LowsDecoderService();
        $atisService->setDataFeed();
        $atisLows = $atisService->getData();

        $atis = [
            'loww' => $atisLoww,
            'lows' => $atisLows,
        ];

        $this->set(compact('atis'));
    }

    public function loww()
    {
        $this->loadModel('Feeds');
        $feed = $this->Feeds->find()
            ->order(['created' => 'DESC'])
            ->first()
            ->toArray();

        $atisService = new LowwDecoderService();
        $atisService->setDataFeed($feed);
        $atis = $atisService->getData();

        $metarService = new MetarService();
        $metar = $metarService->fetchMetar('LOWW');

        $metarDecoderService = new MetarDecoderService();
        $metarDecoder = $metarDecoderService->getMetarDecoder($metar);

        $this->set(compact('atis', 'metarDecoder'));
    }
}
