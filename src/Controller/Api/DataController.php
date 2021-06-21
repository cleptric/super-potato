<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Service\Data\MainDataService;
use App\Service\Data\NotificationsDataService;
use App\Service\Data\SettingsDataService;
use App\Service\MissedApproachService;
use App\Service\RunwayClosedService;
use App\Service\VisualDepatureService;
use Cake\Controller\Controller;

class DataController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Authentication.Authentication');
        $this->loadComponent('Authorization.Authorization');
    }

    public function getData()
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

    public function saveSettings()
    {
        $this->request->allowMethod('post');
        $this->Authorization->skipAuthorization();

        $service = new SettingsDataService();
        $service->setUser($this->Authentication->getIdentity());
        $service->saveData($this->request->getData('settings'));

        return $this->response
            ->withStatus(200)
            ->withType('application/json');
    }

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

    public function saveNotifications()
    {
        $this->request->allowMethod('post');
        $this->Authorization->skipAuthorization();

        $service = new NotificationsDataService();
        $service->setUser($this->Authentication->getIdentity());
        $service->saveData($this->request->getData('notifications'));

        return $this->response
            ->withStatus(200)
            ->withType('application/json');
    }

    public function completeOnboarding()
    {
        $this->request->allowMethod('post');
        $this->Authorization->skipAuthorization();

        $this->loadModel('Users');
        $user = $this->Authentication->getIdentity();
        $user = $this->Users->patchEntity($user, [
            'onboarded' => true,
        ], [
            'accessibleFields' => [
                'onboarded' => true,
            ],
        ]);
        $this->Users->save($user);

        return $this->response
            ->withStatus(200)
            ->withType('application/json');
    }

    public function updateMissedApproach()
    {
        $this->request->allowMethod('post');

        $airportIcao = $this->request->getData('airport');

        $this->loadModel('Airports');
        $airport = $this->Airports->find()
            ->where(['name' => $airportIcao])
            ->first();

        $this->Authorization->authorize($airport, 'updateMissedApproach');

        $service = new MissedApproachService();
        $service->toggleMissedApproach($airport, $this->Authentication->getIdentity());

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
        $service->toggleRunwayClosed($airport, $runways, $this->Authentication->getIdentity());

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
