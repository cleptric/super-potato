<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Service\UsersService;
use Cake\Controller\Controller;

class UsersController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Authentication.Authentication');
        $this->loadComponent('Authorization.Authorization');
    }

    public function changePassword()
    {
        $this->request->allowMethod('post');
        $this->Authorization->skipAuthorization();

        $service = new UsersService();
        $service->setUser($this->Authentication->getIdentity());
        $service->changePassword([
            'current_password' => $this->request->getData('current_password'),
            'new_password' => $this->request->getData('new_password'),
        ]);

        return $this->response
            ->withStatus(204);
    }

    public function deleteAccount()
    {
        $this->request->allowMethod('delete');
        $this->Authorization->skipAuthorization();

        $service = new UsersService();
        $service->setUser($this->Authentication->getIdentity());
        $service->deleteAccount();

        $this->Authentication->logout();

        return $this->response
            ->withStatus(204);
    }
}
