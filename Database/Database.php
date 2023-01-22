<?php
/*
 * This file is part of the niga framework package.
 *
 * (c) Abass Dev <abass@abassdev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Niga\Framework\Database;

use Niga\Framework\Database\Adapter\MysqlAdapter;
use Niga\Framework\Database\Adapter\PostgresqlAdapter;
use Niga\Framework\Database\Adapter\SqliteAdapter;

/**
 * Database connection
 *
 * @author Abass Dev <abass@abassdev.com>
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
                'connection' => $this->getMysqlUrl()
            ],
            "postgres" => [
                'connection' => $this->getPostgresUrl()
            ],
            "sqlite" => [
                'connection' => $this->getSqliteUrl()
            ]
        ];

        $connection = null;
        switch ($this->getDriver()) {
            case 'mysql':
                $connection = (new MysqlAdapter($config['mysql']))->connect();
                break;

            case 'postgres':
                $connection =  (new PostgresqlAdapter($config['postgres']))->connect();
                break;

            case 'sqlite':
                $connection = (new SqliteAdapter($config['sqlite']))->connect();
                break;
        }
        return $connection;
    }
}
