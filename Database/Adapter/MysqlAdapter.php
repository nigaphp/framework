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
   * @return void
   */
    public function __construct(array $configuration)
    {
        $this->configuration = $configuration;
    }
   
   /** MySQL {@inheritdoc} */
    public function connect()
    {
        $pdo = null;
        try {
            $pdo = new PDO("mysql:host={$this->configuration['host']};dbname={$this->configuration['name']}", $this->configuration["user"], $this->configuration["password"]);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $pdo->exec("SET NAMES utf8");
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
        return $pdo;
    }
}
