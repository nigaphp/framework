<?php
/*
 * This file is part of the Nigatedev PHP framework package
 *
 * (c) Abass Ben Cheik <abass@todaysdev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nigatedev\FrameworkBundle\Database;

/**
* Database configuration
*
* @author Abass Ben Cheik <abass@todaysdev.com>
*/
class DatabaseConfiguration
{
    /**
     * Get database url
     *
     * @return array
     */
    public static function getDbUrl(): array
    {
        $dbUrl = parse_url($_ENV['DATABASE_URL']);
        return [
            'driver' => $dbUrl['scheme'] ?? '',
            'host' => $dbUrl['host'] ?? '',
            'port' => $dbUrl['port'] ?? '',
            'username' => $dbUrl['user'] ?? '',
            'password' => $dbUrl['pass'] ?? '',
            'database' => ltrim($dbUrl['path'], '/') ?? '',
            'charset' => 'utf8',
            'prefix' => '',
            'sslmode' => 'require',
        ];
    }
}
