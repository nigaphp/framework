<?php
/*
 * This file is part of the Nigatedev framework package.
 *
 * (c) Abass Ben Cheik <abass@todaysdev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nigatedev\FrameworkBundle\Application;

use Nigatedev\FrameworkBundle\Config\ORMConfig;
use Nigatedev\Framework\Parser\JSONParser;
use Nigatedev\Framework\Parser\Exception\ParseException;

/**
* Application configuration
*
* @author Abass Ben Cheik <abass@todaysdev.com>
*/
class Configuration
{
    /**
     * Define the application document root
     *
     * @return string
     */
    public static function getAppRoot()
    {
        if (php_sapi_name() === "cli") {
            return dirname(dirname(dirname(dirname(__DIR__))));
        }
        return App::$APP_ROOT;
    }
    
    /**
     * Configuration of EntityManager
     */
    public static function getEntityManagerConfig()
    {
        
        try {
            require_once self::getAppRoot()."/config/env.loader.php";
            $getOrmConfig = JSONParser::parseJFile(self::getAppRoot(), "/config/dependencies/doctrine.json");
        } catch (ParseException $e) {
            die($e->getMessage() . " In file " . $e->getFile() . " On line " . $e->getLine());
        }
        $getOrmConfig["connection"]["path"] = self::getAppRoot()."/data/database.sqlite";
        $getOrmConfig["annotation"]["dir"] = [self::getAppRoot()."/src/Entity"];

        return (new ORMConfig())->getEntityManagerConfig(
            $getOrmConfig["connection"],
            $getOrmConfig["annotation"]
        );
    }
}
