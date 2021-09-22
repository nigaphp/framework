<?php

declare(strict_types = 1);

/*
 * This file is part of the Nigatedev framework package.
 *
 * (c) Abass Ben Cheik <abass@todaysdev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nigatedev\FrameworkBundle\Attributes;

use Attribute;

/**
* Route Attribute
*
* @author Abass Ben Cheik <abass@todaysdev.com>
*/

#[Attribute]
class Route
{
    
    /**
     * @var string
     */
    private $path;
    
    /**
     * Route Attribute constructor
     *
     * @param $path    The path, e.g: "/home"
     *
     * @return void
     */
    public function __construct($path)
    {
        $this->path = $path;
    }
    
    /**
     * Get the path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
}
