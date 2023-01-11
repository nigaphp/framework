<?php
/*
 * This file is part of the niga PHP framework package
 *
 * (c) Abass Ben Cheik <abass@todaysdev.com>
 */

namespace Niga\Dumper;

use Niga\Dumper\Template\DumperTemplate;

/**
 * Dumper class
 *
 * @author Abass Ben Cheik <abass@todaysdev.com>
 */
class Dumper extends DumperTemplate
{

    /**
     * @params $dumper can be any type of data
     *
     * @return dump values
     */
    public function dumper($data)
    {
        return $this->pre($data);
    }
}
