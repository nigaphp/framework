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
 * Abstract Database
 *
 * @author Abass Ben Cheik <abass@todaysdev.com>
 */
abstract class AbstractDatabase
{
    
    /**
     * Get database host name
     *
     * @return string
     */
    public function getDbHost(): string
    {
        return $_ENV['DB_HOST'] ?? '';
    }
    
    /**
     * Get database name
     *
     * @return string
     */
    public function getDbName(): string
    {
        return $_ENV['DB_NAME'] ?? '';
    }
    
    /**
     * Get database user name
     *
     * @return string
     */
    public function getDbUser(): string
    {
        return $_ENV['DB_USER'] ?? '';
    }
    
    /**
     * Get database user password
     *
     * @return string
     */
    public function getDbPassword(): string
    {
        return $_ENV['DB_PASSWORD'] ?? '';
    }
     
    /**
     * Database DSN
     *
     * @return string
     */
    public function getDsn(): string
    {
        return $_ENV['DSN'] ?? '';
    }
}
