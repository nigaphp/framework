<?php
/*
 * This file is part of the niga PHP framework package
 *
 * (c) Abass Ben Cheik <abass@todaydevs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Niga\Framework\Http;

use Psr\Http\Message\ServerRequestInterface;
use Niga\Framework\API\API;

/**
 * HTTP request
 *
 * @author Abass Ben Cheik <abass@todaydevs.com>
 */
class Request
{
    /**
     * @var ServerRequestInterface $request
     */
    private $request;

    /**
     * @var API
     */
    public API $api;

    /**
     * Request constructor
     *
     * @param ServerRequestInterface $request
     */
    public function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;
        $this->api = new API();
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
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if ($this->isPost()) {
            foreach ($this->request->getParsedBody() as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
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
     * @return int|null
     */
    public function getId()
    {
        return (int)$_ENV["_path_id"];
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

    /**
     * JSON to Array
     */
    public function toArray($data)
    {
        return json_decode($data, true);
    }
}
