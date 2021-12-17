<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Service\AdminService;
use Cake\Controller\Controller;

class AdminController extends Controller
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

        $user = $this->Authentication->getIdentity();
        $this->Authorization->authorize($user, 'accessAdmin');

        $service = new AdminService();
        $service->setUser($user);
        $data = $service->getData();

        return $this->response
            ->withStatus(200)
            ->withType('application/json')
            ->withStringBody(json_encode($data));
    }

    public function blockUser()
    {
        $this->request->allowMethod('post');

        $user = $this->Authentication->getIdentity();
        $this->Authorization->authorize($user, 'accessAdmin');

        $service = new AdminService();
        $service->setUser($user);
        $data = $service->blockUser([
            'user_id' => $this->request->getData('user_id'),
        ]);

        return $this->response
            ->withStatus(204)
            ->withType('application/json');
    }

    public function unblockUser()
    {
        $this->request->allowMethod('post');

        $user = $this->Authentication->getIdentity();
        $this->Authorization->authorize($user, 'accessAdmin');

        $service = new AdminService();
        $service->setUser($user);
        $data = $service->unblockUser([
            'user_id' => $this->request->getData('user_id'),
        ]);

        return $this->response
            ->withStatus(204)
            ->withType('application/json');
    }
}
