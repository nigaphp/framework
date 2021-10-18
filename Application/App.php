<?php
/*
 * This file is part of the Nigatedev framework package.
 *
 * (c) Abass Ben Cheik <abass@todaysdev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types = 1);

namespace Nigatedev\FrameworkBundle\Application;

use Nigatedev\Diyan\Diyan;
use Nigatedev\FrameworkBundle\Http\Request;
use Nigatedev\FrameworkBundle\Http\Response;
use Nigatedev\FrameworkBundle\Http\Router\Router;
use Nigatedev\FrameworkBundle\Debugger\Debugger;
use Nigatedev\FrameworkBundle\Database\Database;
use Psr\Http\Message\ServerRequestInterface;
use Nigatedev\FrameworkBundle\Attributes\Route;
use ReflectionClass;

/**
* Main application class
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
    * @var string
    */
    public static $APP_ROOT;
    
    /**
    * @var Router
    */
    public Router $router;
    
    /**
    * @var Request
    */
    public Request $request;
    
    /**
    * @var ServerRequestInterface
    */
    public ServerRequestInterface $serverRequest;

    /**
    * @var Debugger
    */
    public Debugger $debugger;

    /**
    * @var Database
    */
    public Database $db;

    /**
    * App constructor
    *
    * @param ServerRequestInterface $serverRequest
    * @param string $appRoot
    * @param array[] $configuration
    *
    * @return void
    */
    public function __construct(ServerRequestInterface $serverRequest, string $appRoot, array $configuration)
    {
        self::$APP_ROOT = $appRoot;
        self::$app = $this;
        $this->serverRequest = $serverRequest;
        (new Configuration($this->serverRequest));
        $this->request = new Request($this->serverRequest);
        $this->router = new Router($this->serverRequest);
        $this->debugger = new Debugger();
        $this->database = new Database($configuration["db"]);
    }
    
    /**
     * Get database connection
     *
     * @return Database
     */
    public function getDatabase(): Database
    {
        return $this->database;
    }
     
    /**
     * Load all your controller
     *
     * @param string[] $controllers   array of controllers class as string[] including the full namespace
     * @return void
     */
    public function routesLoader(array $controllers)
    {
        if (is_array($controllers)) {
            foreach ($controllers as $controller) {
                $class = new ReflectionClass((new $controller));
                foreach ($class->getMethods() as $method) {
                    $routeAttributes = $method->getAttributes(Route::class);
                    foreach ($routeAttributes as $routeAttribute) {
                        $route = $routeAttribute->newInstance();
                        switch ($route->getMethod()) {
                            case 'post':
                                $this->router->post($route->getPath(), [new $controller, $method->getName()]);
                                break;
                            case 'get':
                                $this->router->get($route->getPath(), [new $controller, $method->getName()]);
                                break;
                            case 'get|post':
                                $this->router->post($route->getPath(), [new $controller, $method->getName()]);
                                $this->router->get($route->getPath(), [new $controller, $method->getName()]);
                                break;
                            default:
                                $this->router->get($route->getPath(), [new $controller, $method->getName()]);
                                break;
                        }
                    }
                }
            }
        }
    }

   /**
    * App runner
    * @throws AppException
    *
    * @return void
    */
    public function run()
    {
        $stream = $this->router->pathResolver($this->serverRequest);
        Response::send($stream);
    }
}
