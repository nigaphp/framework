<?php
/*
 * This file is part of the niga PHP framework package
 *
 * (c) Abass Dev <abass@abassdev.com>
 */

namespace Niga\Dumper;

use Niga\Dumper\Template\DumperTemplate;

/**
 * Dumper class
 *
 * @author Abass Dev <abass@abassdev.com>
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
