<?php
/**
 * Routes configuration.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * It's loaded within the context of `Application::routes()` method which
 * receives a `RouteBuilder` instance `$routes` as method argument.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

/*
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 */
/** @var \Cake\Routing\RouteBuilder $routes */
$routes->setRouteClass(DashedRoute::class);

$routes->scope('/', function (RouteBuilder $builder) {
    $builder->connect('/', ['controller' => 'Home', 'action' => 'index']);

    $builder->connect('/api/:controller/:action/*', ['prefix' => 'Api']);
    $builder->connect('/api/:controller/:action', ['prefix' => 'Api']);
    $builder->connect('/api/:controller', ['prefix' => 'Api']);

    $builder->connect('/login', ['controller' => 'Login', 'action' => 'login']);
    $builder->connect('/logout', ['controller' => 'Login', 'action' => 'logout']);
    $builder->connect('/signup', ['controller' => 'Login', 'action' => 'signup']);

    $builder->connect('/loww', ['controller' => 'Home', 'action' => 'loww']);
    $builder->connect('/lowi', ['controller' => 'Home', 'action' => 'loww']);
    $builder->connect('/lows', ['controller' => 'Home', 'action' => 'loww']);
    $builder->connect('/lowg', ['controller' => 'Home', 'action' => 'loww']);
    $builder->connect('/lowk', ['controller' => 'Home', 'action' => 'loww']);
    $builder->connect('/lowl', ['controller' => 'Home', 'action' => 'loww']);

    $builder->fallbacks();
});

/*
 * If you need a different set of middleware or none at all,
 * open new scope and define routes there.
 *
 * ```
 * $routes->scope('/api', function (RouteBuilder $builder) {
 *     // No $builder->applyMiddleware() here.
 *     
 *     // Parse specified extensions from URLs
 *     // $builder->setExtensions(['json', 'xml']);
 *     
 *     // Connect API actions here.
 * });
 * ```
 */
