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
use GuzzleHttp\Psr7\ServerRequest;
use Nigatedev\Framework\Parser\JSONParser;
use Nigatedev\Framework\Parser\Exception\ParseException;
use Psr\Http\Message\ServerRequestInterface;

/**
* Application configuration
*
* @author Abass Ben Cheik <abass@todaysdev.com>
*/
class Configuration
{
    /**
     * @var ServerRequestInterface
     */
    public ServerRequestInterface $request;
    
    /**
     * @var string[]
     */
    public static array $envs = [];
    
    /**
     * @param ServerRequestInterface $request
     * @return void
     */
    public function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;
        self::$envs = $this->request->getServerParams();
    }
    
    /**
     * Define the application document root
     *
     * @return string
     */
    public static function getAppRoot()
    {
        if (php_sapi_name() === "cli") {
            return dirname(__DIR__, 4);
        }
        return App::$APP_ROOT;
    }
    
    /**
     * Get doctrine orm entityManager
     *
     * @return mixed
     */
    public static function getEntityManagerConfig()
    {
        try {
            require_once self::getAppRoot()."/config/env.loader.php";
            $getOrmConfig = self::getParser("/config/dependencies/doctrine.json");
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
    
    /**
     * Application configuration.
     * @return mixed
     */
    public static function getAppConfig()
    {
        return self::getParser("/config/app.json");
    }
    
    /**
     * The default template
     * @return mixed
     */
    public static function getDefaultTemplateConfig()
    {
        return self::getAppConfig()["default_template"];
    }
    
    /**
     * Get json parser
     *
     * @param string $fileToParse     path to the file
     * @return mixed
     */
    private static function getParser(string $fileToParse)
    {
          return  JSONParser::parseJFile(self::getAppRoot(), $fileToParse);
    }
    
    /**
     * @pram string $envKey
     * @return string[]|null
     */
    public static function getEnv(string $envKey)
    {
        return self::$envs[$envKey];
    }
}
