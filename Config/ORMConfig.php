<?php
/*
 * This file is part of the niga framework package.
 *
 * (c) Abass Dev <abass@abassdev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Niga\Framework\Config;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

/**
 * Doctrine orm configuration
 *
 * @author Abass Dev <abass@abassdev.com>
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
