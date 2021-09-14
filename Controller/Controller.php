<?php
/*
 * This file is part of the Nigatedev PHP framework package
 *
 *  (c) Abass Ben Cheik <abass@todaysdev.com>
 */
   
namespace Nigatedev\FrameworkBundle\Controller;

use Nigatedev\FrameworkBundle\Application\App;
use Nigatedev\FrameworkBundle\Application\Configuration as AppConfig;

/**
 * App core controller
 *
 * @author Abass Ben Cheik <abass@todaysdev.com>
 */
class Controller
{
    
    /**
     * @param string $view
     * @param string[] $params
     *
     * @return mixed
     */
    public function render(string $view, array $params = [])
    {
        return App::$app->diyan->render($view, $params);
    }
    
    public function getEntityManager()
    {
        
        return AppConfig::getEntityManagerConfig();
    }
}
