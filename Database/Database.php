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

use Nigatedev\FrameworkBundle\Database\Adapter\MysqlAdapter;
use Nigatedev\FrameworkBundle\Database\Adapter\PostgresqlAdapter;
use Nigatedev\FrameworkBundle\Database\Adapter\SqliteAdapter;

/**
 * Database connection
 *
 * @author Abass Ben Cheik <abass@todaysdev.com>
 */
class Database extends AbstractDatabase
{
   /**
    * Get Database connection
    *
    * @return AdapterInterface|null
    */
    public function getConnection()
    {
        $config = [
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
                   $connection = (new MysqlAdapter($config['mysql']))->connect();
                break;
            
            case 'pgsql':
                  $connection =  (new PostgresqlAdapter($config['pgsql']))->connect();
                break;
        
            case 'sqlite':
                   $connection = (new SqliteAdapter($config['sqlite']))->connect();
                break;
        }
        return $connection;
    }
}
