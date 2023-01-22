<?php
/*
 * This file is part of the niga PHP framework package
 *
 *  (c) Abass Dev <abass@abassdev.com>
 */

namespace Niga\Framework\Debugger;

use Whoops\Run;
use Whoops\Handler\PrettyPageHandler;

/**
 * Debugger class
 *
 * @author Abass Dev <abass@abassdev.com>
 */
class Debugger
{

  /**
   * @var bool $debugMode
   */
  public static $debugMode = false;

  /**
   * Enable debug mode
   *
   * @return void
   */
  public static function enableDebugMode(): void
  {

    $whoops = new Run;
    $whoops->pushHandler(new PrettyPageHandler);
    $whoops->register();

    self::$debugMode = true;
  }

  /**
   * Get debug mode status
   *
   * @return bool
   */
  public function getDebugMode(): bool
  {
    return self::$debugMode;
  }
}
