<?php
/*
 * This file is part of the Nigatedev PHP framework package
 *
 * (c) Abass Ben Cheik <abass@todaysdev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * data that was distributed with this source code.
 */

declare(strict_types=1);

namespace Nigatedev\FrameworkBundle\Parser;

/**
 * Parser
 *
 * @author Abass Ben Cheik <abass@todaysdev.com>
 */
class Parser extends AbstractParser
{
  
  private $data;
  
 /**
  * Constructor
  */
  public function __construct($data)
  {
      $this->data = $data;
      
      if (file_exists($this->data)) {
          if($this->extensionIsSupported($this->data)) {
             $this->parseIt($this->data);
          }
      }
      
  }
}