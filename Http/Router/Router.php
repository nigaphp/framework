<?php
/*
 * This file is part of the Nigatedev PHP framework package
 *
 * (c) Abass Ben Cheik <abass@todaysdev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nigatedev\FrameworkBundle\Http\Router;

use Nigatedev\FrameworkBundle\Application\App;
use Nigatedev\FrameworkBundle\Http\Request;
use Nigatedev\FrameworkBundle\Http\Response;
use Nigatedev\FrameworkBundle\Http\HttpException;
use Nigatedev\FrameworkBundle\Debugger\Debugger;

use Nigatedev\Diyan\Diyan;

/**
 * Route generator
 *
 * @author Abass Ben Cheik <abass@todaysdev.com>
 */
class Router extends Debugger
{
    /**
     * @var Request
     */
    private Request $request;

    /**
     * @var Response instance
     */
    private Response $response;

    /**
     * @var Diyan instance
     */
    public Diyan $diyan;
    
    /**
     * @var array[] $routes
     */
    protected $routes = [];

    public function __construct(Request $request)
    {
        $this->response = new Response();
        $this->request = new $request;
        $this->diyan = new Diyan($this->request);
    }

    /**
     * @param string $path
     * @param mixed $callback
     *
     * @return void
     */
    public function get(string $path, $callback): void
    {
        $this->routes["get"][$path] = $callback;
    }
    
    /**
     * @param string $path
     * @param mixed $callback
     *
     * @return void
     */
    public function post(string $path, $callback): void
    {
        $this->routes["post"][$path] = $callback;
    }
    
    /**
     * @return void
     */
    public function load(string $callback)
    {
        $callback = require_once($callback);
      
        foreach ($callback as $key => $value) {
            $this->routes["get"][$key] = $value;
        }
    }

    /**
     * @throws HttpException
     *
     * @return mixed
     */
    public function pathResolver()
    {
        $method = $this->request->getMethod();
        $path = $this->request->getPath();

        $callback = $this->routes[$method][$path] ?? false;


        if (is_string($callback)) {
            return $this->diyan->render($callback);
        }

        if ($path === "/") {
            $home = isset($this->routes[$method]["/"]) ?? false;
            if (!$home) {
                $this->response->setStatusCode(404);
                if ($this->getDebugMode()) {
                    $this->diyan->setBody($this->diyan->getHomeNotFound());
                } else {
                    $this->diyan->setBody($this->diyan->getNotFound());
                }
                return $this->diyan->render(null, []);
            }
        }

        if ($callback === false) {
            $this->response->setStatusCode(404);
            $this->diyan->setBody($this->diyan->getNotFound());
            return $this->diyan->render(null, []);
        }

        if (is_array($callback)) {
            if (!class_exists($callback[0]::class)) {
                $this->response->setStatusCode(404);
                $this->diyan->setBody($this->diyan->getNotFound());
                return $this->diyan->render(null, []);
            } else {
                $callback[0] = new $callback[0];
            }
        }
        echo call_user_func($callback);
    }
}
