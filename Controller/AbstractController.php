<?php
/*
 * This file is part of the Nigatedev PHP framework package
 *
 * (c) Abass Ben Cheik <abass@todaysdev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace Nigatedev\FrameworkBundle\Controller;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Nigatedev\FrameworkBundle\Application\App;
use Nigatedev\FrameworkBundle\Http\Request;
use Nigatedev\FrameworkBundle\Http\Response;
use Nigatedev\Diyan\Diyan;
use Nigatedev\FrameworkBundle\Application\Configuration as AppConfig;

/**
 * Main abstract controller
 *
 * @author Abass Ben Cheik <abass@todaysdev.com>
 */
abstract class AbstractController extends Request
{
    /**
     * @var Response
     */
    protected $response;
    
    /**
     * @var Diyan
     */
    protected $diyan;
    
    /**
     * Construitor
     *
     * @return void
     */
    public function __construct()
    {
        $this->response = new Response();
        $this->diyan = new Diyan(new Request());
    }
     
    /**
     * @param string $view
     * @param string[] $params
     *
     * @return mixed
     */
    public function render(string $view, array $params = [])
    {
        $defaultTemplate = $this->getDefaultTemplate();

        if ($defaultTemplate === "diyan") {
            return $this->diyan->render($view, $params);
        } elseif ($defaultTemplate === "twig") {
            $loader = new FilesystemLoader(AppConfig::getAppRoot()."/views");
            $twig = new Environment($loader, [
            'cache' => false,
            ]);
            $template = $twig->load("{$view}.twig");
            echo $template->render($params);
        } else {
            die("Bad template configuration");
        }
    }
    
    /**
     * Redirect to not found template and set the status code to 404
     *
     * @return mixed
     */
    public function redirectToNotFound()
    {
        $this->response->setStatusCode(404);
        $notFound = $this->diyan->getNotFound();
        $this->diyan->setBody($notFound);
        return $this->diyan->render(null, []);
    }
    
    /**
     * @return mixed
     */
    public function getEntityManager()
    {
        return AppConfig::getEntityManagerConfig();
    }
    
    /**
     * @return mixed
     */
    public function getDefaultTemplate()
    {
        return AppConfig::getDefaultTemplateConfig();
    }
}
