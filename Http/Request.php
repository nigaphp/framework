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
use GuzzleHttp\Psr7\ServerRequest;

/**
 * HTTP request
 *
 * @author Abass Ben Cheik <abass@todaysdev.com>
 */
class Request 
{
    /**
     * @return string
     */
    public function isPost()
    {
        return $this->fromGbl()->getMethod() === "POST";
    }
    
    /**
     * @return string
     */
    public function isGet()
    {
        return $this->fromGbl()->getMethod() === "GET";
    }
  
    public function getBody()
    {
        $body = [];
        if ($this->isGet()) {
            foreach ($this->fromGbl()->getParsedBody() as $key => $value) {
               $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS) ;
            }
        }
        
        if ($this->isPost()) {
            foreach ($this->fromGbl()->getParsedBody() as $key => $value) {
               $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS) ;
            }
        }
        return $body;
    }

    /**
     * Get the name
     *
     * @return string
     */
    public function getRouteName($routeName)
    {
        $queryParams = array_unique($this->fromGbl());
        if (array_key_exists($routeName, $queryParams)) {
            return $queryParams[$routeName];
        }
    }
    
    public function fromGbl()
    {
        return ServerRequest::fromGlobals();
    }
}
