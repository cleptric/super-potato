<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Service\MissedApproachService;
use App\Service\RunwayClosedService;
use App\Service\VisualDepatureService;
use App\Service\Data\MainDataService;
use Cake\Controller\Controller;

class DataController extends Controller
{

    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Authentication.Authentication');
        $this->loadComponent('Authorization.Authorization');
    }

    public function index()
    {
        $this->request->allowMethod('get');
        $this->Authorization->skipAuthorization();

        $service = new MainDataService();
        $service->setUser($this->Authentication->getIdentity());
        $data = $service->getData();

        return $this->response
            ->withStatus(200)
            ->withType('application/json')
            ->withStringBody(json_encode($data));
    }

    public function updateMissedApproach()
    {
        $this->request->allowMethod('post');

        $airportIcao = $this->request->getData('airport');

        $this->loadModel('Airports');
        $airport = $this->Airports->find()
            ->where(['name' => $airportIcao])
            ->first();

        $this->Authorization->authorize($airport, 'updateMissedApporach');

        $service = new MissedApproachService();
        $service->toggleMissedApproach($airport);

        return $this->response
            ->withStatus(200);
    }

    public function updateRunwayClosed()
    {
        $this->request->allowMethod('post');

        $airportIcao = $this->request->getData('airport');
        $runways = $this->request->getData('runways');

        $this->loadModel('Airports');
        $airport = $this->Airports->find()
            ->where(['name' => $airportIcao])
            ->first();

        $this->Authorization->authorize($airport, 'updateRunwayClosed');

        $service = new RunwayClosedService();
        $service->toggleRunwayClosed($airport, $runways);

        return $this->response
            ->withStatus(200);
    }

    public function updateVisualDepature()
    {
        $this->request->allowMethod('post');

        $airportIcao = $this->request->getData('airport');
        $direction = $this->request->getData('direction');

        $this->loadModel('Airports');
        $airport = $this->Airports->find()
            ->where(['name' => $airportIcao])
            ->first();

        $this->Authorization->authorize($airport, 'updateVisualDepature');

        $service = new VisualDepatureService();
        $service->toggleVisualDepature($airport, $direction);

        return $this->response
            ->withStatus(200);
    }
}
