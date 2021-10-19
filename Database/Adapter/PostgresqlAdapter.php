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
class PostgresqlAdapter implements AdapterInterface
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
   
   /** Postgresql {@inheritdoc} */
    public function connect()
    {
        $pdo = null;
        try {
            $pdo = new PDO($_ENV["DB_URL"]);
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
        return $pdo;
    }
}
