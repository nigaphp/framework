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

use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use function Http\Response\send;

/**
 * Response class
 *
 * @author Abass Ben Cheik <abass@todaysdev.com>
 */
class Response extends GuzzleResponse implements ResponseInterface
{
    public function send($stream)
    {
        return send($stream);
    }
}
