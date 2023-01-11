<?php
/*
 * This file is part of the niga framework package.
 *
 * (c) Abass Ben Cheik <abass@todaysdev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Niga\Framework\Database;

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
    public static function getConfig(): array
    {
        $dbUrl = parse_url($_ENV['DATABASE_URL']);
        return [
            'driver' => $dbUrl['scheme'] ?? '',
            'host' => $dbUrl['host'] ?? '',
            'port' => $dbUrl['port'] ?? '',
            'username' => $dbUrl['user'] ?? '',
            'password' => $dbUrl['pass'] ?? '',
            'database' => ltrim($dbUrl['path'], '/') ?? '',
            'path' => $dbUrl['path'] ?? '',
            'charset' => 'utf8mb4',
            'prefix' => '',
            'sslmode' => 'require',
        ];
    }

    /**
     * Get database driver
     *
     * @return string
     */
    public function getDriver()
    {
        if ($this->getConfig()['driver'] !== '') {
            return $this->getConfig()['driver'];
        }
        return null;
    }

    /**
     * Get database host
     *
     * @return string
     */
    public function getHost()
    {
        if ($this->getConfig()['host']) {
            return $this->getConfig()['host'];
        }
        return null;
    }

    /**
     * Get database port
     *
     * @return string
     */
    public function getPort()
    {
        if ($this->getConfig()['port'] !== '') {
            return $this->getConfig()['port'];
        }
        return null;
    }

    /**
     * Get database username
     *
     * @return string
     */
    public function getUser()
    {
        if ($this->getConfig()['username'] !== '') {
            return $this->getConfig()['username'];
        }
        return null;
    }

    /**
     * Get database password
     *
     * @return string
     */
    public function getPassword()
    {
        if ($this->getConfig()['password'] !== '') {
            return $this->getConfig()['password'];
        }
        return null;
    }

    /**
     * Get database name
     *
     * @return string
     */
    public function getDbName()
    {
        if ($this->getConfig()['database'] !== '') {
            return $this->getConfig()["database"];
        }
        return null;
    }

    /**
     * Get database path
     *
     * @return string
     */
    public function getPath()
    {
        if ($this->getConfig()['path'] !== '') {
            return $this->getConfig()['path'];
        }
        return null;
    }
}
