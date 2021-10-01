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
class Request extends ServerRequest implements ServerRequestInterface
{
    public function __construct(
        string $method,
        $uri,
        array $headers = [],
        $body = null,
        string $version = '1.1',
        array $serverParams = []
    ) {
        parent::__construct($method, $uri, $headers, $body, $version, $serverParams);
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
     * @return string|null
     */
    public function getId()
    {
        return $this->getQueryParams()["id"] ?? null;
    }
    
    /**
     * @return ServerRequest|null
     */
    public function isSubmitted()
    {
        return $this->getQueryParams()["id"] ?? null;
    }

    /**
     * @return ServerRequest|null
     */
    public function isGranted()
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
