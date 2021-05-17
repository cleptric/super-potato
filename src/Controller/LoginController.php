<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

class LoginController extends AppController
{

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        $this->viewBuilder()->setLayout('login');
        $this->Authentication->allowUnauthenticated(['login', 'signup']);
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

            return $this->redirect(['action' => 'login']);
        }
    }

    public function logout()
    {
        $this->Authentication->logout();

        return $this->redirect(['action' => 'login']);
    }

    public function signup()
    {
        $this->loadModel('Users');
        $user = $this->Users->newEmptyEntity();

        if ($this->request->is('post')) {

            $user = $this->Users->patchEntity($user, [
                'username' => $this->request->getData('username'),
                'password' => $this->request->getData('password'),
                'sign-up-code' => $this->request->getData('sign-up-code'),
            ], [
                'accessibleFields' => [
                    'username' => true,
                    'password' => true,
                    'sign-up-code' => true,
                ],
            ]);

            if ($this->Users->save($user)) {

                $user = $this->Users->get($user->id);
                $this->Authentication->setIdentity($user);

                return $this->redirect(['controller' => 'Home', 'action' => 'index']);
            }

            $this->Flash->error(__('Unable to create your account.'));
        }

        $this->set(compact('user'));
    }
}
