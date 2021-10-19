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
abstract class AbstractDatabase extends DatabaseConfiguration
{
    
    /**
     * @var string[]
    */
     const  SUPPORTED_DRIVER = ["mysql", 'pgsql', "sqlite"];
    
    /**
     * Get database url
     *
     * @return string
     */
    public function dbURL(): string
    {
        return $this->getDBUrl();
    }
    
    /**
     * Get Postgresql url
     *
     * @return mixed
     */
    public function getPgsqlUrl()
    {
        if ($this->getDriver() === "pgsql") {
            return $this->dbURL();
        } else {
            return '';
        }
    }
    
    /**
     * Get Sqlite url
     *
     * @return mixed
     */
    public function getSqliteUrl()
    {
        if ($this->getDriver() === "sqlite") {
            return $this->dbURL();
        } else {
            return null;
        }
    }
    
    /**
     * Get MySQL url
     *
     * @return mixed
     */
    public function getMysqlUrl()
    {
        if ($this->getDriver() === "mysql") {
            return $this->dbURL();
        } else {
            return null;
        }
    }
    
    public function getDriver()
    {
        $dbUrl = substr($this->dbURL(), 0, 6);
        
        if (preg_match('/^mysql/', $dbUrl)) {
            return 'mysql';
        } elseif (preg_match('/^pgsql/', $dbUrl)) {
            return 'pgsql';
        } elseif (preg_match('/^sqlite/', $dbUrl)) {
            return 'sqlite';
        } else {
            echo "Error bad database URL configuration";
            exit(1);
        }
    }
    
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
