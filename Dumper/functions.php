<?php
/*
 * This file is part of the niga PHP framework package
 *
 * (c) Abass Dev <abass@abassdev.com>
 */

use Niga\Dumper\Dumper;

/**
 * dumper
 *
 * @param mixed $data
 * @return void
 */
function dump($data)
{
  echo (new Dumper())->dumper($data);
}

/**
 * dump and die
 *
 * @param mixed $data
 * @return void
 */
function dd($data)
{
  die((new dumper())->dumper($data));
}
