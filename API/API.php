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

namespace Niga\Framework\API;


/**
 * API REST
 *
 * @author Abass Ben Cheik <abass@todaydevs.com>
 */
class API
{

    /**
     * Fetch(get)
     * 
     * @return string|array[]
     */
    public function get(string $url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $res = curl_exec($ch);
        echo $res;
        curl_close($ch);
    }
}
