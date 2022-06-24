<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\User;
use App\Model\Entity\Organization;
use App\Model\Entity\OrganizationsUser;
use Cake\Event\EventInterface;
use Cake\Http\Client;

/**
 * @property \App\Model\Table\UsersTable $Users
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 */
class LoginController extends AppController
{
    /**
     * @param \Cake\Event\EventInterface $event The event
     * @return void
     */
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

    /**
     * @return \Cake\Http\Response|null|void
     */
    public function login($organization_id = null)
    {
        $result = $this->Authentication->getResult();
        // If the user is logged in send them away.
        if ($result->isValid()) {
            $target = $this->Authentication->getLoginRedirect() ?? '/';

            return $this->redirect($target);
        }

        if($organization_id === null) {
            dd('default landing Page');
        }
        
        $this->loadModel('Organizations');
        $organization = $this->Organizations->find()
            ->where([
                'id' => $organization_id,
            ])
            ->first();

        if($organization === null) {
            dd('default landing Page');
        }
        $this->set(compact('organization'));
    }

    /**
     * @return \Cake\Http\Response|null|void
     */
    public function startOauth($organization_id = null)
    {
        if($organization_id === null) {
            dd('default landing Page');
        }

        $url = env('VATSIM_SSO_ENDPOINT') . '/oauth/authorize' .
            '?client_id=' . env('VATSIM_SSO_CLIENT_ID') .
            '&redirect_uri=' . env('VATSIM_SSO_REDIRECT_URL') .
            '&response_type=code' .
            '&scope=full_name+vatsim_details' .
            '&state=' . $organization_id;

        return $this->redirect($url);
    }

    /**
     * @return \Cake\Http\Response|null|void
     */
    public function oauth()
    {
        $code = $this->request->getQuery('code');
        $organization_id = $this->request->getQuery('state');

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

                $this->loadModel('Organizations');
                $organization = $this->Organizations->find()
                    ->where([
                        'id' => $organization_id,
                    ])
                    ->first();

                if($organization) {
                    $this->loadModel('Users');
                    $user = $this->Users->find()
                        ->where([
                            'vatsim_id IS' => $responseJson['data']['cid'],
                        ])
                        ->first();

                    $user = $this->Users->get($user->id);
    
                    if ($user) {
                        $this->loadModel('OrganizationsUsers');
                        $organization_user = $this->OrganizationsUsers->find()
                            ->where([
                                'organization_id' => $organization->id,
                                'user_id' => $user->id,
                            ])
                            ->first();

                        if($organization_user) {
                            if($organization_user->role == User::STATUS_ACTIVE) {
                                $this->Authentication->setIdentity($user);
                                return $this->redirect(['controller' => 'Home', 'action' => 'index']);
                            } else {
                                dd('pending or blocked from org');
                            }
                        } else {
                            // user exists but has no connection to org -> add and check for auth point
                            $organization_user_ = $this->OrganizationsUsers->newEntity([
                                'organization_id' => $organization_id,
                                'user_id' => $user->id,
                                'role' => User::STATUS_PENDING,
                            ], [
                                'accessibleFields' => [
                                    'organization_id' => true,
                                    'user_id' => true,
                                    'role' => true,
                                ],
                            ]);

                            if($organization->authorization_endpoint) {
                                // send request to auth point
                                $response = $http->get($organization->authorization_endpoint, [
                                    'vatsimid' => $responseJson['data']['cid'],
                                ], [
                                    'headers' => [
                                        'Authorization' => 'Bearer ' . env('VACC_AUTH_TOKEN'),
                                    ],
                                ]);
                                
                                if ($response->isSuccess() === false) {
                                    $this->Flash->error('You are not part of ' . $organization->name);
                                    return $this->redirect('/login/login/' . $organization_id);
                                } else {
                                    $organization_user_ = $this->OrganizationsUsers->patchEntity($organization_user_, [
                                        'role' => User::STATUS_ACTIVE,
                                    ], [
                                        'accessibleFields' => [
                                            'role' => true,
                                        ],
                                    ]);
                                    $this->OrganizationsUsers->save($organization_user_);

                                    $this->Authentication->setIdentity($user);
                                    return $this->redirect(['controller' => 'Home', 'action' => 'index']);
                                }
                            } else {
                                // save as pending
                                if ($this->OrganizationsUsers->save($organization_user_)) {
                                    dd('pending or blocked from org');
                                }
                            }
                        }

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
        }

        $this->Flash->error('Vatsim SSO sign in failed');

        return $this->redirect('/login/login/' . $organization_id);
    }

    /**
     * @return \Cake\Http\Response|null|void
     */
    public function logout()
    {
        $this->Authentication->logout();

        return $this->redirect(['action' => 'login']);
    }

    /**
     * @return \Cake\Http\Response|null|void
     */
    public function imprint(): void
    {
        # code...
    }

    /**
     * @return \Cake\Http\Response|null|void
     */
    public function privacyPolicy(): void
    {
        # code...
    }
}
