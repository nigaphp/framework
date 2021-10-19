<?php
/*
 * This file is part of the Nigatedev framework package.
 *
 * (c) Abass Ben Cheik <abass@todaysdev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nigatedev\FrameworkBundle\Database;

use PDO;
use Nigatedev\FrameworkBundle\Database\Adapter\MysqlAdapter;
use Nigatedev\FrameworkBundle\Database\Adapter\PostgresqlAdapter;
use Nigatedev\FrameworkBundle\Database\Adapter\SqliteAdapter;
use Nigatedev\FrameworkBundle\Database\Exception\DBException;

/**
 * Database connection
 *
 * @author Abass Ben Cheik <abass@todaysdev.com>
 */
class Database extends AbstractDatabase
{
   /**
    * @var string
    */
    private $dbURL;
    
    /**
     * Constructor
     *
     * @param string[] $configuration
     * @param string[] $options
     *
     * @return void
     */
    public function __construct($configuration)
    {
        $this->config = $configuration;
    }
    
   /**
    * Get Database connection
    *
    * @return mixed
    */
    public function getConnection()
    {
        $configurations = [
            "mysql" => [
                'url' => $this->getMysqlUrl()
            ],
            "pgsql" => [
                'url' => $this->getPgsqlUrl()
            ],
            "sqlite" => [
                'url' => $this->getSqliteUrl()
            ]
        ];
        $connection = null;
        switch ($this->getDriver()) {
            case 'mysql':
                   $connection = (new MysqlAdapter($configurations['mysql']))->connect();
                break;
            
            case 'pgsql':
                  $connection =  (new PostgresqlAdapter($configurations['pgsql']))->connect();
                break;
        
            case 'sqlite':
                   $connection = (new SqliteAdapter($configurations['sqlite']))->connect();
                break;
            
            default:
                echo "Error with database URL configuration";
                break;
        }
        return $connection;
    }
}
