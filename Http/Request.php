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

namespace Nigatedev\FrameworkBundle\Http;

use Psr\Http\Message\ServerRequestInterface;

/**
 * HTTP request
 *
 * @author Abass Ben Cheik <abass@todaysdev.com>
 */
class Request
{
    /**
     * @var ServerRequestInterface $request
     */
     private $request;
     
    /**
     * Request constructor
     *
     * @param ServerRequestInterface $request
     */
    public function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;
    }
    
    /**
     * @return bool
     */
    public function isPost()
    {
        return $this->request->getMethod() === "POST";
    }
    
    /**
     * @return bool
     */
    public function isGet()
    {
        return $this->request->getMethod() === "GET";
    }
  
    
    /**
     * Sanitize globals variables $_POST and $_GET
     *
     * @return mixed
     */
    public function getBody()
    {
        $body = [];
        if ($this->isGet()) {
            foreach ($this->request->getParsedBody() as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS) ;
            }
        }
        
        if ($this->isPost()) {
            foreach ($this->request->getParsedBody() as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS) ;
            }
        }
        return $body;
    }

    /**
     * Get route name
     *
     * @return string
     */
    public function getRouteName(string $routeName)
    {
        $queryParams = array_unique($this->request);
        if (array_key_exists($routeName, $queryParams)) {
            return $queryParams[$routeName];
        }
    }
    
    /**
     * All globals variables $_POST,$_GET...
     *
     * @return ServerRequestInterface
     */
    public function fromGlobals(): ServerRequestInterface
    {
        return $this->request;
    }
}
