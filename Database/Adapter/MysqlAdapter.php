<?php
/*
 * This file is part of the Nigatedev PHP framework package
 *
 * (c) Abass Ben Cheik <abass@todaysdev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nigatedev\FrameworkBundle\Database\Adapter;

use PDO;

/**
 * Database connection
 *
 * @author Abass Ben Cheik <abass@todaysdev.com>
 */
class MysqlAdapter implements AdapterInterface
{
  
  /**
   * @var string[]
   */
    private array $configuration = [];
   
  /**
   * Constructor
   *
   * @param string[] $configuration;
   */
    public function __construct(array $configuration)
    {
        $this->config = $configuration;
    }
   
   /**
    * Try to connect to the database
    *
    * @return mixed
    * @throw PDOException
    */
    public function connect()
    {
        $pdo = null;
     
        $configuration = $this->config;
     
        try {
            $pdo = new PDO("mysql:host={$configuration['host']};dbname={$configuration['name']}", $configuration["user"], $configuration["password"]);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $pdo->exec("SET NAMES utf8");
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
     
        return $pdo;
    }
}
