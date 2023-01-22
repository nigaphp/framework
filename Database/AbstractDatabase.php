<?php
/*
 * This file is part of the niga PHP framework package
 *
 * (c) Abass Dev <abass@abassdev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Niga\Framework\Database;

use Niga\Framework\Database\Exception\ConfigurationException;

/**
 * Abstract database
 *
 * @author Abass Dev <abass@abassdev.com>
 */
abstract class AbstractDatabase extends DatabaseConfiguration
{

    /**
     * @var string[]
     */
    protected const  SUPPORTED_DRIVER = ["mysql", "postgres", "sqlite"];

    /**
     * @var array
     */
    private $dbDriver = [];

    /**
     * Constructor
     *
     * @return void
     * @throws ConfigurationException
     */
    public function __construct()
    {
        if (!in_array($this->getDriver(), self::SUPPORTED_DRIVER)) {
            throw new ConfigurationException("FATAL ERROR: Unknown database driver ! ");
        }
    }

    /**
     * Get MySQL database url
     *
     * @return array[]|false
     */
    public function getMysqlUrl()
    {
        if ($this->getDriver() === "mysql") {
            return $this->getConfig();
        }
        return false;
    }

    /**
     * Get Postgresql database url
     *
     * @return array[]|false
     */
    public function getPostgresUrl()
    {
        if ($this->getDriver() === "postgres") {
            return $this->getConfig();
        }
        return false;
    }

    /**
     * Get SQLite database url
     *
     * @return array[]|false
     */
    public function getSqliteUrl()
    {
        if ($this->getDriver() === "sqlite") {
            return $this->getConfig();
        }
        return false;
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
