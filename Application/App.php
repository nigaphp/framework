<?php
/*
 * This file is part of the niga framework package.
 *
 * (c) Abass Dev <abass@abassdev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Niga\Framework\Application;

use Niga\Framework\Http\Request;
use Niga\Framework\Http\Response;
use Niga\Framework\Http\Router\Router;
use Niga\Framework\Debugger\Debugger;
use Niga\Framework\Database\Database;
use Psr\Http\Message\ServerRequestInterface;
use Niga\Framework\Attributes\Route;
use ReflectionClass;

/**
 * Main application class
 *
 * @author Abass Dev <abass@abassdev.com>
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
     * App constructor
     *
     * @param ServerRequestInterface $serverRequest
     * @param string $appRoot
     *
     * @return void
     */
    public function __construct(ServerRequestInterface $serverRequest, string $appRoot)
    {
        self::$APP_ROOT = $appRoot;
        self::$app = $this;
        $this->serverRequest = $serverRequest;
        (new Configuration($this->serverRequest));
        $this->request = new Request($this->serverRequest);
        $this->router = new Router($this->serverRequest);
        $this->debugger = new Debugger();
    }

    /**
     * Get database connection
     *
     * @return Database
     */
    public function getDatabase(): Database
    {
        return (new Database());
    }

    /**
     * Controllers loader
     *
     * @param string[] $controllers   array of controllers class as string[] including the full namespace
     * @return void
     */
    public function loader(array $controllers)
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
     * Run the app
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
