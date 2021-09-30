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
    * @var Diyan
    */
    public Diyan $diyan;
    /**
    * @var Response
    */
    public Response $response;

    /**
    * @var Request
    */
    public Request $request;

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
        $this->request = new Request();
        $this->response = new Response();
        $this->debugger = new Debugger();
        $this->router = new Router($this->request);
        $this->diyan = new Diyan($this->request);
        $this->db = new DB($configs["db"]);
    }

    /**
    * @throws AppException
    *
    * @return void
    */
    public function run(): void
    {
        if (version_compare(Configurator::CURRENT_VERSION, PHP_VERSION, "<")) {
            $message = (string)printf("Fatal: Your are using PHP version %s which is not enough to run Nigatedev app... minimum is %s", Configurator::CURRENT_VERSION, PHP_VERSION);
            throw new AppException($message);
        }
        echo $this->router->pathResolver();
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
                    $routeAttributes = $method->getAttributes(\Nigatedev\FrameworkBundle\Attributes\Route::class);

                    if (empty($routeAttributes)) {
                        continue;
                    }

                    foreach ($routeAttributes as $routeAttribute) {
                        $route = $routeAttribute->newInstance();
                            self::$app->router->post($route->getPath(), [new $controller, $method->getName()]);
                            self::$app->router->get($route->getPath(), [new $controller, $method->getName()]);
                    }
                }
            }
        }
    }
}
