<?php
/*
 * This file is part of the Nigatedev PHP framework package
 *
 * (c) Abass Ben Cheik <abass@todaysdev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types = 1);

namespace Nigatedev\FrameworkBundle\Http\Router;

use Nigatedev\FrameworkBundle\Application\App;
use GuzzleHttp\Psr7\Response;
use Nigatedev\FrameworkBundle\Http\HttpException;
use Nigatedev\FrameworkBundle\Http\Request;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Nigatedev\Diyan\Diyan;

/**
 * Route generator
 *
 * @author Abass Ben Cheik <abass@todaysdev.com>
 */
class Router
{
    /**
     * @var Diyan instance
     */
    public Diyan $diyan;
    
    /**
     * @var array[] $routes
     */
    protected $routes = [];

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
     * @var string $callback
     *
     * @return void
     */
    public function load(string $callback)
    {
        foreach ($callback as $key => $value) {
            $this->routes["get"][$key] = $value;
        }
    }

    /**
     * Resole the path/url
     *
     * @throws HttpException
     *
     * @return ResponseInterface
     */
    public function pathResolver(ServerRequestInterface $req)
    {
        $this->diyan = new Diyan();
        $method = $req->getMethod();
        $url = $req->getUri()->getPath() ?? "/";
        if (strlen($url) > 1 && $url[-1] === "/") {
            return new Response(301, ["Location" => substr($url, 0, -1)]);
        }
        $callback = $this->routes[\strtolower($method)][$url] ?? false;

        if ($callback === false) {
            return new Response(404, [], $this->diyan->render("errors/_404"));
        }
        
        if (is_string($callback)) {
            return new Response(200, [], $this->diyan->render($callback));
        }

        if (is_array($callback)) {
            if (!class_exists($callback[0]::class)) {
                return new Response(404, [], $this->diyan->render("errors/_404"));
            } else {
                $callback[0] = new $callback[0];
            }
        }
        
        ob_start();
        echo call_user_func($callback, (new Request));
        $stream = ob_get_clean();
        return new Response(200, [], $stream);
    }
}
