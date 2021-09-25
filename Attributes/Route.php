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

use Nigatedev\FrameworkBundle\Http\Request;

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
     * @var Request
     */
    private $request;
    
    /**
     * Route Attribute constructor
     *
     * @param string $path    The path, (e.g: "/home")
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
    
        if (preg_match("/\d+$/", $_SERVER["REQUEST_URI"], $id)) {
            $_GET["id"] = $id[0];
            $filterPath = preg_replace("/{id}/", $id[0], $this->path);
        } else {
            $filterPath = $this->path;
        }
        return $filterPath;
    }
}
