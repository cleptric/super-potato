<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Client;
use Cake\Routing\Router;

class LoginController extends AppController
{

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        $this->viewBuilder()->setLayout('login');
        $this->Authentication->allowUnauthenticated(['login', 'startOauth', 'oauth']);
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

    public function startOauth()
    {
        $url = env('VATSIM_SSO_ENDPOINT') . '/authorize' .
            '?client_id=' . env('VATSIM_SSO_CLIENT_ID') .
            '&redirect_uri=' . env('VATSIM_SSO_REDIRECT_URL') .
            '&response_type=code' .
            '&scope=full_name+vatsim_details+email';

        return $this->redirect($url);
    }

    public function oauth()
    {
        $code = $this->request->getQuery('code');

        $http = new Client();
        $response = $http->post(env('VATSIM_SSO_ENDPOINT') . '/token', [
            'grant_type' => 'authorization_code',
            'client_id' => env('VATSIM_SSO_CLIENT_ID'),
            'client_secret' => env('VATSIM_SSO_CLIENT_SECRET'),
            'redirect_uri' => env('VATSIM_SSO_REDIRECT_URL'),
            'code' => $code,
        ]);

        if ($response->isOk()) {
            $responseJson = $response->getJson();

            $accessToken = $responseJson['access_token'];
            $okenExpiresIn = $responseJson['expires_in'];

            $response = $http->get(env('VATSIM_SSO_ENDPOINT') . '/api/user', [], [
                'headers' => [
                    'Authorization' => 'Bearer '. $accessToken,
                    'Accept' => 'application/json'
                ],
            ]);

            if ($response->isOk()) {
                $responseJson = $response->getJson();

                $this->loadModel('Users');
                $user = $this->Users->find()
                    ->where([
                        'vatsim_id IS' => $responseJson['data']['cid']
                    ])
                    ->first();

                if ($user) {
                    $user = $this->Users->get($user->id);
                    $this->Authentication->setIdentity($user);

                    return $this->redirect(['controller' => 'Home', 'action' => 'index']);
                } else {
                    $user = $this->Users->newEntity([
                        'email' => $responseJson['data']['personal']['email'],
                        'vatsim_id' => $responseJson['data']['cid'],
                        'full_name' => $responseJson['data']['personal']['name_full'],
                        'subdivision' => $responseJson['data']['vatsim']['subdivision']['id'],
                    ], [
                        'accessibleFields' => [
                            'email' => true,
                            'vatsim_id' => true,
                            'full_name' => true,
                            'subdivision' => true,
                        ],
                    ]);

                    if ($this->Users->save($user)) {
                        $user = $this->Users->get($user->id);
                        $this->Authentication->setIdentity($user);

                        return $this->redirect(['controller' => 'Home', 'action' => 'index']);
                    }
                }
            }
        }

        $this->Flash->error('Vatsim SOO sign in failed');

        return $this->redirect(['action' => 'login']);
    }

    public function logout()
    {
        $this->Authentication->logout();

        return $this->redirect(['action' => 'login']);
    }
}
