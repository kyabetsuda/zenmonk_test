<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
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

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

/**
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
 *
 * Cache: Routes are cached to improve performance, check the RoutingMiddleware
 * constructor in your `src/Application.php` file to change this behavior.
 *
 */
Router::defaultRouteClass(DashedRoute::class);

Router::scope('/', function (RouteBuilder $routes) {
    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */

    $routes->connect('/', ['controller' => 'Top']);

    //Articles
    $routes->connect('/users/*', ['controller' => 'Error']);
    $routes->connect('/articles/', ['controller' => 'Articles', 'action'=>'index']);
    $routes->connect('/articles/index', ['controller' => 'Articles', 'action'=>'index']);
    $routes->connect('/articles/getContent', ['controller' => 'Articles', 'action'=>'getContent']);
    $routes->connect('/articles/uploadArticle', ['controller' => 'Articles', 'action'=>'uploadArticle']);
    $routes->connect('/articles/plusCategory', ['controller' => 'Articles', 'action'=>'plusCategory']);
//    $routes->connect('/articles/view/**', ['controller' => 'Articles', 'action'=>'view']);
    $routes->connect('/articles/*', ['controller' => 'Error']);

    //Pictures
    $routes->connect('/pictures/', ['controller' => 'Pictures', 'action'=>'index']);
    $routes->connect('/pictures/index', ['controller' => 'Pictures', 'action'=>'index']);
    $routes->connect('/pictures/getContent', ['controller' => 'Pictures', 'action'=>'getContent']);
//    $routes->connect('/pictures/view/**', ['controller' => 'Pictures', 'action'=>'view']);
    $routes->connect('/pictures/*', ['controller' => 'Error']);

    //Processings
    // $routes->connect('/processings/', ['controller' => 'Processings', 'action'=>'index']);
    // $routes->connect('/processings/index', ['controller' => 'Processings', 'action'=>'index']);
    // $routes->connect('/processings/getContent', ['controller' => 'Processings', 'action'=>'getContent']);
    // $routes->connect('/processings/view/**', ['controller' => 'Processings', 'action'=>'view']);
    // $routes->connect('/processings/*', ['controller' => 'Error']);

    //Videos
    $routes->connect('/videos/', ['controller' => 'Videos', 'action'=>'index']);
    $routes->connect('/videos/index', ['controller' => 'Videos', 'action'=>'index']);
    $routes->connect('/videos/getContent', ['controller' => 'Videos', 'action'=>'getContent']);
//    $routes->connect('/processings/view/**', ['controller' => 'Processings', 'action'=>'view']);
    $routes->connect('/videos/*', ['controller' => 'Error']);

    //Users
    $routes->connect('/aDIXNbg5EJ9AiUSmHWrH1ZwaZwcw3t08aNnVaNzv9oA=/login', ['controller' => 'Users', 'action' => 'login']);
    $routes->connect('/aDIXNbg5EJ9AiUSmHWrH1ZwaZwcw3t08aNnVaNzv9oA=/logout', ['controller' => 'Users', 'action' => 'logout']);
    $routes->connect('/aDIXNbg5EJ9AiUSmHWrH1ZwaZwcw3t08aNnVaNzv9oA=/top', ['controller' => 'Users', 'action' => 'top']);
    //$routes->connect('/aDIXNbg5EJ9AiUSmHWrH1ZwaZwcw3t08aNnVaNzv9oA=/index', ['controller' => 'Users', 'action' => 'index']);
    //$routes->connect('/aDIXNbg5EJ9AiUSmHWrH1ZwaZwcw3t08aNnVaNzv9oA=/add', ['controller' => 'Users', 'action' => 'add']);

    //Articles
    $routes->connect('/aDIXNbg5EJ9AiUSmHWrH1ZwaZwcw3t08aNnVaNzv9oA=/addArticles', ['controller' => 'Articles', 'action' => 'add']);
    $routes->connect('/aDIXNbg5EJ9AiUSmHWrH1ZwaZwcw3t08aNnVaNzv9oA=/editArticles/**', ['controller' => 'Articles', 'action' => 'edit']);
    $routes->connect('/aDIXNbg5EJ9AiUSmHWrH1ZwaZwcw3t08aNnVaNzv9oA=/editOrDeleteList', ['controller' => 'Articles', 'action' => 'editOrDeleteList']);
    $routes->connect('/aDIXNbg5EJ9AiUSmHWrH1ZwaZwcw3t08aNnVaNzv9oA=/deleteArticles/**', ['controller' => 'Articles', 'action' => 'delete']);

    //Pictures
    $routes->connect('/aDIXNbg5EJ9AiUSmHWrH1ZwaZwcw3t08aNnVaNzv9oA=/addPictures', ['controller' => 'Pictures', 'action' => 'add']);
    $routes->connect('/aDIXNbg5EJ9AiUSmHWrH1ZwaZwcw3t08aNnVaNzv9oA=/deletePictures/**', ['controller' => 'Pictures', 'action' => 'delete']);

    //Processings
    // $routes->connect('/aDIXNbg5EJ9AiUSmHWrH1ZwaZwcw3t08aNnVaNzv9oA=/addProcessings', ['controller' => 'Processings', 'action' => 'add']);
    // $routes->connect('/aDIXNbg5EJ9AiUSmHWrH1ZwaZwcw3t08aNnVaNzv9oA=/deleteProcessings/**', ['controller' => 'Processings', 'action' => 'delete']);

    //Videos
    $routes->connect('/aDIXNbg5EJ9AiUSmHWrH1ZwaZwcw3t08aNnVaNzv9oA=/addVideos', ['controller' => 'Videos', 'action' => 'add']);
    $routes->connect('/aDIXNbg5EJ9AiUSmHWrH1ZwaZwcw3t08aNnVaNzv9oA=/deleteVideos/**', ['controller' => 'Videos', 'action' => 'delete']);

    /**
     * ...and connect the rest of 'Pages' controller's URLs.
     */
    //$routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);`
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $routes->fallbacks(DashedRoute::class);
});
