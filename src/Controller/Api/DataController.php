<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Model\Entity\Airport;
use App\Service\Vatsim\DataFeedService;
use App\Service\Vatsim\MetarService;
use App\Service\Metar\MetarDecoderService;
use App\Service\Atis\LowwDecoderService;
use Cake\Controller\Controller;
use Cake\I18n\FrozenTime;
use Cake\Utility\Hash;
use ZMQContext;
use ZMQ;

class DataController extends Controller
{

    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Authentication.Authentication');
    }

    public function index()
    {
        $this->request->allowMethod('get');

        $this->loadModel('Feeds');
        $feed = $this->Feeds->find()
            ->order(['created' => 'DESC'])
            ->first()
            ->toArray();

        $atisService = new LowwDecoderService();
        $atisService->setDataFeed($feed);
        $atis = $atisService->getData();

        $this->loadModel('Metar');
        $metar = $this->Metar->find()
            ->order(['created' => 'DESC'])
            ->first()
            ->toArray();

        $metarDecoderService = new MetarDecoderService();
        $metarDecoderService->setMetar($metar['data']['LOWW']);
        $metar = $metarDecoderService->getData();

        $this->loadModel('Airports');
        $airport = $this->Airports->find()
            ->where(['name' => 'loww'])
            ->first();

        $data = [
            'user' => [
                'id' => $this->Authentication->getIdentityData('id'),
                'name' => $this->Authentication->getIdentityData('full_name'),
                'vatsim_id' => $this->Authentication->getIdentityData('vatsim_id'),
            ],
            'loww' => [
                'atis' => $atis,
                'metar' => $metar,
                'missed_approach' => $airport->missed_approach,
                'missed_approach_timeout' => $airport->missed_approach_timeout->toUnixString(),
                'closed_runways' => $airport->closed_runways ?? [],
                'closed_runways_timeout' => $airport->closed_runways_timeout->toUnixString(),
                'visual_depature' => $airport->visual_depatures ?? [],
            ],
        ];

        return $this->response
            ->withStatus(200)
            ->withType('application/json')
            ->withStringBody(json_encode($data));
    }

    public function updateMissedApproach()
    {
        //$this->request->allowMethod('post');

        $this->loadModel('Airports');
        $airport = $this->Airports->find()
            ->where(['name' => 'loww'])
            ->first();

        if ($airport->missed_approach_timeout > new FrozenTime()) {
            return $this->response
                ->withStatus(400);
        }

        $missedApproach = $airport->missed_approach;
        $missedApproachTimeout = new FrozenTime();

        if ($missedApproach === false) {
            $missedApproach = true;
            $missedApproachTimeout = new FrozenTime(Airport::MISSED_APPROACH_TIMEOUT);

            $context = new ZMQContext();
            $socket = $context->getSocket(ZMQ::SOCKET_PUSH);
            $socket->connect("tcp://localhost:5555");
            $socket->send(json_encode(['type' => 'missed-approach']));
        } else {
            $missedApproach = false;
        }

        $airport = $this->Airports->patchEntity($airport, [
            'missed_approach' => $missedApproach,
            'missed_approach_timeout' => $missedApproachTimeout,
        ], [
            'accessibleFields' => [
                'missed_approach' => true,
                'missed_approach_timeout' => true,
            ],
        ]);

        $this->Airports->save($airport);

        $context = new ZMQContext();
        $socket = $context->getSocket(ZMQ::SOCKET_PUSH);
        $socket->connect("tcp://localhost:5555");
        $socket->send(json_encode(['type' => 'refresh']));

        return $this->response
            ->withStatus(200);
    }

    public function updateRunwayClosed()
    {
        $this->request->allowMethod('post');

        $this->loadModel('Airports');
        $airport = $this->Airports->find()
            ->where(['name' => 'loww'])
            ->first();

        if ($airport->closed_runways_timeout > new FrozenTime()) {
            return $this->response
                ->withStatus(400);
        }

        $data = (array)$airport->closed_runways;
        $runways = $this->request->getData('runways');
        $closedRunwaysTimeout = new FrozenTime();

        if (($key = array_search($runways, $data)) !== false) {
            unset($data[$key]);
            $data = array_values($data);

            $context = new ZMQContext();
            $socket = $context->getSocket(ZMQ::SOCKET_PUSH);
            $socket->connect("tcp://localhost:5555");
            $socket->send(json_encode(['type' => 'runway-reopened']));
        } else {
            $data = Hash::merge($data, $runways);
            $closedRunwaysTimeout = new FrozenTime(Airport::RUNWAY_CLOSED_TIMEOUT);

            $context = new ZMQContext();
            $socket = $context->getSocket(ZMQ::SOCKET_PUSH);
            $socket->connect("tcp://localhost:5555");
            $socket->send(json_encode(['type' => 'runway-closed']));
        }

        $airport = $this->Airports->patchEntity($airport, [
            'closed_runways' => $data,
            'closed_runways_timeout' => $closedRunwaysTimeout,
        ], [
            'accessibleFields' => [
                'closed_runways' => true,
                'closed_runways_timeout' => true,
            ],
        ]);
        $this->Airports->save($airport);

        $context = new ZMQContext();
        $socket = $context->getSocket(ZMQ::SOCKET_PUSH);
        $socket->connect("tcp://localhost:5555");
        $socket->send(json_encode(['type' => 'refresh']));

        return $this->response
            ->withStatus(200);
    }

    public function updateVisualDepature()
    {
        $this->request->allowMethod('post');

        $this->loadModel('Airports');
        $airport = $this->Airports->find()
            ->where(['name' => 'loww'])
            ->first();

        $data = (array)$airport->visual_depatures;
        $runway = $this->request->getData('direction');
        if (($key = array_search($runway, $data)) !== false) {
            unset($data[$key]);
            $data = array_values($data);
        } else {
            $data = Hash::merge($data, $runway);
        }

        $airport = $this->Airports->patchEntity($airport, [
            'visual_depatures' => $data,
        ], [
            'accessibleFields' => [
                'visual_depatures' => true,
            ],
        ]);
        $this->Airports->save($airport);

        $context = new ZMQContext();
        $socket = $context->getSocket(ZMQ::SOCKET_PUSH);
        $socket->connect("tcp://localhost:5555");
        $socket->send(json_encode(['type' => 'refresh']));

        return $this->response
            ->withStatus(200);
    }
}
