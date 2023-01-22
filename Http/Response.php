<?php
/*
 * This file is part of the niga PHP framework package
 *
 * (c) Abass Dev <abass@abassdev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Niga\Framework\Http;

use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use function Http\Response\send;

/**
 * Response class
 *
 * @author Abass Dev <abass@abassdev.com>
 */
class Response extends GuzzleResponse implements ResponseInterface
{
    public static function send($stream)
    {
        return send($stream);
    }
}
