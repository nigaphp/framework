<?php
/*
 * This file is part of the niga PHP framework package
 *
 * (c) Abass Dev <abass@abassdev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Niga\Framework\Database\Adapter;

use PDO;

/**
 * Database connection
 *
 * @author Abass Dev <abass@abassdev.com>
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
        $this->configuration = $configuration["connection"];
    }

    /** MySQL {@inheritdoc} */
    public function connect()
    {
        $pdo = null;
        try {
            $pdo = new PDO("mysql:" . sprintf(
                "host=%s;port=%s;user=%s;password=%s;dbname=%s",
                $this->configuration["host"],
                $this->configuration["port"],
                $this->configuration["username"],
                $this->configuration["password"],
                $this->configuration["database"]
            ));
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $pdo->exec("SET NAMES " . $this->configuration['charset']);
        } catch (\PDOException $e) {
            echo "ERROR: Can't connect to MySQL database ";
        }
        return $pdo;
    }
}
