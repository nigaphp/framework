<?php
/*
 * This file is part of the Nigatedev PHP framework package
 *
 * (c) Abass Ben Cheik <abass@todaysdev.com>
 */

namespace Nigatedev\FrameworkBundle\Database;

use Nigatedev\FrameworkBundle\Database\Exception\DBException;
use PDO;

/**
* Database Configuration
*
* @author Abass Ben Cheik <abass@todaysdev.com>
*/
class DatabaseConfiguration
{

    public static function getDBUrl()
    {
        try {
            $url = $_ENV['DB_URL'];
        } catch (DBException $e) {
            echo "DATABASE CONFIGURATION ERROR: ".$e->getMessage()." in ". $e->getFile()." file on line ".$e->getLine();
            exit(1);
        }
        
        return $url;
    }
}
