<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Service\UsersService;
use Cake\Controller\Controller;
use Cake\Http\Response;

/**
 * @property \App\Model\Table\UsersTable $Users
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 */
class UsersController extends Controller
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
    public function deleteAccount(): Response
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
