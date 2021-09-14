<?php
/*
 * This file is part of the Nigatedev framework package.
 *
 * (c) Abass Ben Cheik <abass@todaysdev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nigatedev\FrameworkBundle\Config;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

/**
* Doctrine orm configuration
*
* @author Abass Ben Cheik <abass@todaysdev.com>
*/
class ORMConfig
{
    /**
    * Get doctrine orm entityManager
    */
    public function getEntityManagerConfig($connection, $annotation)
    {

        $config = Setup::createAnnotationMetadataConfiguration(
            $annotation["dir"],
            $annotation["mode"],
            $annotation["proxyDir"],
            $annotation["cache"],
            $annotation["reader"]
        );

        return EntityManager::create($connection, $config);
    }
}
