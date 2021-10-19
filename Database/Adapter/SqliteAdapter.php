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
class SqliteAdapter implements AdapterInterface
{
  
  /**
   * @var string[]
   */
    private array $configuration = [];
   
  /**
   * Constructor
   *
   * @param string[] $configuration
   */
    public function __construct(array $configuration)
    {
        $this->configuration = $configuration;
    }
   
   /** SQLite {@inheritdoc} */
    public function connect()
    {
        $pdo = null;
        try {
            $pdo = new PDO($this->configuration["url"]);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Error encountered: trying to connect to SQLite database";
        }
        return $pdo;
    }
}
