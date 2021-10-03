<?php
/*
 * This file is part of the Nigatedev framework package.
 *
 * (c) Abass Ben Cheik <abass@todaysdev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nigatedev\FrameworkBundle\Application;

use Nigatedev\Diyan\Diyan;

use Nigatedev\FrameworkBundle\Http\Request;
use Nigatedev\FrameworkBundle\Http\Response;
use Nigatedev\FrameworkBundle\Http\Router\Router;
use Nigatedev\FrameworkBundle\Debugger\Debugger;
use Nigatedev\FrameworkBundle\Config\Configurator;
use Nigatedev\FrameworkBundle\Database\DB;
use Psr\Http\Message\ServerRequestInterface;
use Nigatedev\FrameworkBundle\Attributes\Route;
use ReflectionClass;

/**
* The Nigatedev PHP framework main core application class
*
* @author Abass Ben Cheik <abass@todaysdev.com>
*/
class App
{

    /**
    * @var App
    */
    public static App $app;

    /**
    * @var string $APP_ROOT
    */
    public static $APP_ROOT;
    
    /**
    * @var Router
    */
    public Router $router;

    /**
    * @var Debugger
    */
    public Debugger $debugger;

    /**
    * @var DB
    */
    public DB $db;

    /**
    * App constructor
    *
    * @param string $appRoot
    * @param array[] $configs
    */
    public function __construct(string $appRoot, array $configs)
    {
        self::$APP_ROOT = $appRoot;
        self::$app = $this;
        $this->debugger = new Debugger();
        $this->router = new Router();
        $this->db = new DB($configs["db"]);
    }

    /**
    * @throws AppException
    *
    * @return void
    */
    public function run(ServerRequestInterface $req)
    {
        $stream = $this->router->pathResolver($req);
        Response::send($stream);
    }
    
    /**
     * Load all your controller
     *
     * @param array $controllers   array of controllers class as string[] including the full namespace
     *
     * @return void
     */
    public function controllerLoader(array $controllers)
    {
        if (is_array($controllers)) {
            foreach ($controllers as $controller) {
                $class = new ReflectionClass($controller);
                foreach ($class->getMethods() as $method) {
                    $routeAttributes = $method->getAttributes(Route::class);
                    foreach ($routeAttributes as $routeAttribute) {
                        $route = $routeAttribute->newInstance();
                        if ($route->getMethod() === "post") {
                            $this->router->post($route->getPath(), [new $controller, $method->getName()]);
                        } elseif ($route->getMethod() === "get") {
                            $this->router->get($route->getPath(), [new $controller, $method->getName()]);
                        } elseif ($route->getMethod() === "get|post") {
                            $this->router->post($route->getPath(), [new $controller, $method->getName()]);
                            $this->router->get($route->getPath(), [new $controller, $method->getName()]);
                        } else {
                            $this->router->get($route->getPath(), [new $controller, $method->getName()]);
                        }
                    }
                }
            }
        }
    }
}
