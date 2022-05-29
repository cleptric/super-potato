<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\User;
use Cake\Event\EventInterface;
use Cake\Http\Client;

class LoginController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        $this->viewBuilder()->setLayout('login');
        $this->Authentication->allowUnauthenticated([
            'login',
            'imprint',
            'privacyPolicy',
            'startOauth',
            'oauth',
        ]);
        $this->Authorization->skipAuthorization();
    }

    public function login()
    {
        $result = $this->Authentication->getResult();
        // If the user is logged in send them away.
        if ($result->isValid()) {
            $target = $this->Authentication->getLoginRedirect() ?? '/';

            return $this->redirect($target);
        }
    }

    public function startOauth()
    {
        $url = env('VATSIM_SSO_ENDPOINT') . '/oauth/authorize' .
            '?client_id=' . env('VATSIM_SSO_CLIENT_ID') .
            '&redirect_uri=' . env('VATSIM_SSO_REDIRECT_URL') .
            '&response_type=code' .
            '&scope=full_name+vatsim_details';

        return $this->redirect($url);
    }

    public function oauth()
    {
        $code = $this->request->getQuery('code');

        $http = new Client();
        $response = $http->post(env('VATSIM_SSO_ENDPOINT') . '/oauth/token', [
            'grant_type' => 'authorization_code',
            'client_id' => env('VATSIM_SSO_CLIENT_ID'),
            'client_secret' => env('VATSIM_SSO_CLIENT_SECRET'),
            'redirect_uri' => env('VATSIM_SSO_REDIRECT_URL'),
            'code' => $code,
        ]);

        if ($response->isSuccess()) {
            $responseJson = $response->getJson();

            $accessToken = $responseJson['access_token'];
            $okenExpiresIn = $responseJson['expires_in'];

            $response = $http->get(env('VATSIM_SSO_ENDPOINT') . '/api/user', [], [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Accept' => 'application/json',
                ],
            ]);

            if ($response->isSuccess()) {
                $responseJson = $response->getJson();

                // Only allow login for VACC Austria members
                // $response = $http->get(env('VACC_AUTH_ENDPOINT'), [
                //     'vatsimid' => $responseJson['data']['cid'],
                // ], [
                //     'headers' => [
                //         'Authorization' => 'Bearer ' . env('VACC_AUTH_TOKEN'),
                //     ],
                // ]);
                //
                // if ($response->isSuccess() === false) {
                //     $this->Flash->error('You are not part of the VACC Austria');
                //
                //     return $this->redirect(['action' => 'login']);
                // }

                $this->loadModel('Users');
                $user = $this->Users->find()
                    ->where([
                        'vatsim_id IS' => $responseJson['data']['cid'],
                    ])
                    ->first();

                if ($user) {
                    $user = $this->Users->get($user->id);
                    $this->Authentication->setIdentity($user);

                    return $this->redirect(['controller' => 'Home', 'action' => 'index']);
                } else {
                    $user = $this->Users->newEntity([
                        'vatsim_id' => $responseJson['data']['cid'],
                        'full_name' => $responseJson['data']['personal']['name_full'],
                        'status' => User::STATUS_ACTIVE,
                        'role' => User::ROLE_USER,
                    ], [
                        'accessibleFields' => [
                            'vatsim_id' => true,
                            'full_name' => true,
                            'status' => true,
                            'role' => true,
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

    public function imprint(): void
    {
        # code...
    }

    public function privacyPolicy(): void
    {
        # code...
    }
}
