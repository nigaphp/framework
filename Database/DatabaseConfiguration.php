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
     * @return string
     */
    public static function getDBUrl(): string
    {
        return $_ENV['DATABASE_URL'] ?? '';
    }
}
