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
        $this->loadModel('Feeds');
        $feed = $this->Feeds->find()
            ->order(['created' => 'DESC'])
            ->first()
            ->toArray();

        $atisService = new LowwDecoderService();
        $atisService->setDataFeed($feed);
        $atisLoww = $atisService->getData();

        $atisService = new LowsDecoderService();
        $atisService->setDataFeed($feed);
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

        $this->loadModel('Metar');
        $metar = $this->Metar->find()
            ->order(['created' => 'DESC'])
            ->first()
            ->toArray();

        $atisService = new LowwDecoderService();
        $atisService->setDataFeed($feed);
        $atis = $atisService->getData();

        $metarDecoderService = new MetarDecoderService();
        $metarDecoderService->setMetar($metar['data']['LOWW']);
        $metarDecoder = $metarDecoderService->getMetarDecoder();

        $this->set(compact('atis', 'metarDecoder'));
    }
}
