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
class SqliteAdapter implements AdapterInterface
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
            $pdo = new PDO("sqlite:" . sprintf("%s", $this->configuration["database"]));
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, $this->configuration['fetch-mode'] ?? PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "ERROR: Can't connect to SQLite database ";
        }
        return $pdo;
    }
}
