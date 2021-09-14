<?php
/*
 * This file is part of the Nigatedev PHP framework package
 *
 * (c) Abass Ben Cheik <abass@todaysdev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Nigatedev\FrameworkBundle\Config;

use Nigatedev\FrameworkBundle\Application\App;
use Nigatedev\FrameworkBundle\Parser\Parser;

/**
 * Config files loader
 *
 * @author Abass Ben Cheik <abass@todaysdev.com>
 */
class Loader
{
  /**
   * string $path
   */
    private $path;
  
 /**
  * Constructor
  */
    public function __construct()
    {
        $this->path = App::$APP_ROOT;
    }
  
  /**
   * Import files
   *
   * @param string $file         Name of the file to import
   * @param bool|string $path    File path/directory default => $APP_ROOT
   * @param bool $parse          True if the file can be and should be parsed  example ["yaml", "json"...] files can be parsed
   *
   * @return mixed
   */
    public function import($file, $path = false, $parse = false)
    {
        if ($path !== false) {
            $this->path = $path;
        }
        if ($parse === true) {
            return new Parser($this->path.$file);
        }
        return $this->path.$file;
    }
  
  /**
   * Load only config files
   *
   * @param string $file  file to load
   * @return string
   */
    public static function load(string $file)
    {
        return App::$APP_ROOT."/config/$file";
    }
}
