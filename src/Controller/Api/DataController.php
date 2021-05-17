<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Service\Vatsim\DataFeedService;
use App\Service\Vatsim\MetarService;
use App\Service\Metar\MetarDecoderService;
use App\Service\Atis\LowwDecoderService;
use Cake\Controller\Controller;
use Cake\Utility\Hash;
use ZMQContext;
use ZMQ;

class DataController extends Controller
{

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
            'loww' => [
                'atis' => $atis,
                'metar' => $metar,
                'missed_approach' => $airport->missed_approach,
                'closed_runways' => $airport->closed_runways ?? [],
                'visual_depature' => $airport->visual_depatures ?? [],
            ],
        ];

        return $this->response
            ->withStatus(200)
            ->withType('application/json')
            ->withStringBody(json_encode($data));
    }

    public function missedApproach()
    {
        $this->request->allowMethod('post');

        $this->loadModel('Airports');
        $airport = $this->Airports->find()
            ->where(['name' => 'loww'])
            ->first();

        $airport = $this->Airports->patchEntity($airport, [
            'missed_approach' => true,
        ], [
            'accessibleFields' => [
                'missed_approach' => true,
            ],
        ]);
        $this->Airports->save($airport);

        $context = new ZMQContext();
        $socket = $context->getSocket(ZMQ::SOCKET_PUSH);
        $socket->connect("tcp://localhost:5555");
        $socket->send(json_encode(['type' => 'missed-approach']));

        return $this->response
            ->withStatus(200);
    }

    public function cancelMissedApproach()
    {
        $this->request->allowMethod('post');

        $this->loadModel('Airports');
        $airport = $this->Airports->find()
            ->where(['name' => 'loww'])
            ->first();

        $airport = $this->Airports->patchEntity($airport, [
            'missed_approach' => false,
        ], [
            'accessibleFields' => [
                'missed_approach' => true,
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

        $data = (array)$airport->closed_runways;
        $runways = $this->request->getData('runways');
        if (($key = array_search($runways, $data)) !== false) {
            unset($data[$key]);
            $data = array_values($data);

            $context = new ZMQContext();
            $socket = $context->getSocket(ZMQ::SOCKET_PUSH);
            $socket->connect("tcp://localhost:5555");
            $socket->send(json_encode(['type' => 'runway-reopened']));
        } else {
            $data = Hash::merge($data, $runways);

            $context = new ZMQContext();
            $socket = $context->getSocket(ZMQ::SOCKET_PUSH);
            $socket->connect("tcp://localhost:5555");
            $socket->send(json_encode(['type' => 'runway-closed']));
        }

        $airport = $this->Airports->patchEntity($airport, [
            'closed_runways' => $data
        ], [
            'accessibleFields' => [
                'closed_runways' => true,
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
