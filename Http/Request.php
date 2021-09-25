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
    /**
     * @var mixed $serverRequest
     */
    private $serverRequest;
    
    public static function fromGlobals()
    {
        return ServerRequest::fromGlobals();
    }
    
    /**
     * @return string
     */
    public function getMethod()
    {
        return strtolower(self::fromGlobals()->getMethod());
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
}
