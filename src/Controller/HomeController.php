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
    }

    public function loww()
    {
        return $this->render('index');
    }
}
