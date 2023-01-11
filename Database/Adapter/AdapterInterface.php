<?php
/*
 * This file is part of the Nigatedev PHP framework package
 *
 * (c) Abass Ben Cheik <abass@todaysdev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Niga\Framework\Database\Adapter;

use PDO;

/**
 * Adapter interface
 *
 * @author Abass Ben Cheik <abass@todaysdev.com>
 */
interface AdapterInterface
{
    
   /**
    * Database connection
    *
    * @return PDO|null
    * @throw \PDOException
    */
    public function connect();
}
