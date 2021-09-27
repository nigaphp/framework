<?php
/*
 * This file is part of the Nigatedev PHP framework package
 *
 * (c) Abass Ben Cheik <abass@todaysdev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nigatedev\FrameworkBundle\Http;

use GuzzleHttp\Psr7\ServerRequest;

/**
 * HTTP request
 *
 * @author Abass Ben Cheik <abass@todaysdev.com>
 */
class Request
{
    private $query = [];
    /**
     * Request constructor
     */
    public function __construct()
    {
    }
    
    /**
     * @var mixed $serverRequest
     */
    private $serverRequest;
    
    public static function fromGlobals()
    {
        return ServerRequest::fromGlobals();
    }
    
    /**
     * Get HTTP request method
     * @return string
     */
    public function getMethod()
    {
        return strtolower(self::fromGlobals()->getMethod());
    }
  
    
    /**
     * @return string
     */
    public function isPost()
    {
        return $this->getMethod() === "post";
    }
    
    /**
     * @return string
     */
    public function isGet()
    {
        return $this->getMethod() === "get";
    }
  
    /**
     * @return string
     */
    public function getPath()
    {
        $path = self::fromGlobals()->getUri()->getPath() ?? "/";
        return $path;
    }
    
    /**
     * @return array
     */
    public function getQueryParams()
    {
        return self::fromGlobals()->getQueryParams();
    }
    
    /**
     * @return string|null
     */
    public function getId()
    {
        return $this->getQueryParams()["id"] ?? null;
    }
    
    /**
     * Get the name
     *
     * @return string
     */
    public function getRouteName($routeName)
    {
        $queryParams = array_unique($this->getQueryParams());
        if (array_key_exists($routeName, $queryParams)) {
            return $queryParams[$routeName];
        }
    }
}
