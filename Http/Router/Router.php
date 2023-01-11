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

namespace Niga\Framework\Http\Router;

use Niga\Framework\Application\App;
use GuzzleHttp\Psr7\Response;
use Niga\Framework\Http\HttpException;
use Niga\Framework\Http\Request;
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
     * @param ServerRequestInterface $request
     */
    public function __construct(ServerRequestInterface $request)
    {
        $this->diyan = new Diyan($request);
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
    public function pathResolver(ServerRequestInterface $request): ResponseInterface
    {
        $method = $request->getMethod();
        $url = $request->getUri()->getPath() ?? "/";
        
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
        
        ob_start();
        echo call_user_func($callback, App::$app->request);
        $stream = ob_get_clean();
        return new Response(200, [], $stream);
    }
}
