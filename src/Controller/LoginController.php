<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Client;

class LoginController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        $this->viewBuilder()->setLayout('login');

        $this->Authentication->allowUnauthenticated(['login', 'signup', 'imprint']);
        $this->Authorization->skipAuthorization();

        $this->loadModel('Users');
    }

    public function login()
    {
        $result = $this->Authentication->getResult();
        // If the user is logged in send them away.
        if ($result->isValid()) {
            $target = $this->Authentication->getLoginRedirect() ?? '/';

            return $this->redirect($target);
        }

        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error('Invalid username or password');
        }
    }

    public function signup()
    {
        $user = $this->Users->newEmptyEntity();

        if ($this->request->is(['post'])) {
            $user = $this->Users->patchEntity($user, [
                'vatsim_id' => $this->request->getData('vatsim_id'),
                'full_name' => $this->request->getData('full_name'),
                'username' => $this->request->getData('username'),
                'password' => $this->request->getData('password'),
            ], [
                'accessibleFields' => [
                    'vatsim_id' => true,
                    'full_name' => true,
                    'username' => true,
                    'password' => true,
                ],
            ]);

            if ($this->Users->save($user)) {
                $user = $this->Users->get($user->id);
                $this->Authentication->setIdentity($user);

                return $this->redirect(['controller' => 'Home', 'action' => 'index']);
            }
        }

        $this->set(compact('user'));
    }

    public function logout()
    {
        $this->Authentication->logout();

        return $this->redirect(['action' => 'login']);
    }

    public function imprint()
    {
    }
}
