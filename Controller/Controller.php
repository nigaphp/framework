<?php
/*
 * This file is part of the Nigatedev PHP framework package
 *
 *  (c) Abass Ben Cheik <abass@todaysdev.com>
 */
   
namespace Nigatedev\FrameworkBundle\Controller;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
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
        $defaultTemplate = $this->getDefaultTemplate();
       
        if (array_key_exists("default_template", $defaultTemplate)) {
            $key = $defaultTemplate["default_template"];
            if ($key === "diyan") {
                return App::$app->diyan->render($view, $params);
            }
            $loader = new FilesystemLoader(AppConfig::getAppRoot()."/views");
            $twig = new Environment($loader, [
            'cache' => false,
            ]);
            $template = $twig->load("{$view}.twig");
            echo $template->render($params);
        } else {
            die("Fatal: bad template configuration");
        }
    }
    
    public function getEntityManager()
    {
        
        return AppConfig::getEntityManagerConfig();
    }
    
    public function getDefaultTemplate()
    {
        
        return AppConfig::getDefaultTemplateConfig();
    }
}
