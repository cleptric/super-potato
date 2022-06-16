<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Service\Data\MainDataService;
use App\Service\Data\NotificationsDataService;
use App\Service\Data\SettingsDataService;
use App\Service\MissedApproachService;
use App\Service\RunwayClosedService;
use Cake\Controller\Controller;
use Cake\Http\Response;

/**
 * @property \App\Model\Table\AirportsTable $Airports
 * @property \App\Model\Table\RunwaysTable $Runways
 */
class DataController extends Controller
{
    /**
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Authentication.Authentication');
        $this->loadComponent('Authorization.Authorization');
    }

    /**
     * @return \Cake\Http\Response
     */
    public function getData(): Response
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

    /**
     * @return \Cake\Http\Response
     */
    public function getSettings()
    {
        $this->request->allowMethod('get');
        $this->Authorization->skipAuthorization();

        $service = new SettingsDataService();
        $service->setUser($this->Authentication->getIdentity());
        $data = $service->getData();

        return $this->response
            ->withStatus(200)
            ->withType('application/json')
            ->withStringBody(json_encode($data));
    }

    /**
     * @return \Cake\Http\Response
     */
    public function saveSettings()
    {
        $this->request->allowMethod('post');
        $this->Authorization->skipAuthorization();

        $service = new SettingsDataService();
        $service->setUser($this->Authentication->getIdentity());
        $service->saveData($this->request->getData('settings'));

        return $this->response
            ->withStatus(204);
    }

    /**
     * @return \Cake\Http\Response
     */
    public function getNotifications()
    {
        $this->request->allowMethod('get');
        $this->Authorization->skipAuthorization();

        $service = new NotificationsDataService();
        $service->setUser($this->Authentication->getIdentity());
        $data = $service->getData();

        return $this->response
            ->withStatus(200)
            ->withType('application/json')
            ->withStringBody(json_encode($data));
    }

    /**
     * @return \Cake\Http\Response
     */
    public function saveNotifications()
    {
        $this->request->allowMethod('post');
        $this->Authorization->skipAuthorization();

        $service = new NotificationsDataService();
        $service->setUser($this->Authentication->getIdentity());
        $service->saveData($this->request->getData('notifications'));

        return $this->response
            ->withStatus(204);
    }

    /**
     * @return \Cake\Http\Response
     */
    public function updateMissedApproach()
    {
        $this->request->allowMethod('post');

        $airportIcao = $this->request->getData('airport');

        $this->loadModel('Airports');
        $airport = $this->Airports->find()
            ->where(['icao' => $airportIcao])
            ->first();

        $this->Authorization->authorize($airport, 'updateMissedApproach');

        $service = new MissedApproachService();
        $service->toggleMissedApproach($airport, $this->Authentication->getIdentity());

        return $this->response
            ->withStatus(204);
    }

    /**
     * @return \Cake\Http\Response
     */
    public function updateRunwayClosed()
    {
        $this->request->allowMethod('post');

        $airportIcao = $this->request->getData('airport');
        $runwayId = $this->request->getData('runway_id');

        $this->loadModel('Airports');
        $airport = $this->Airports->find()
            ->where(['icao' => $airportIcao])
            ->first();

        $this->loadModel('Runways');
        $runway = $this->Runways->find()
            ->where(['id' => $runwayId])
            ->first();

        $this->Authorization->authorize($airport, 'updateRunwayClosed');

        $service = new RunwayClosedService();
        $service->toggleRunwayClosed($airport, $runway, $this->Authentication->getIdentity());

        return $this->response
            ->withStatus(204);
    }
}
