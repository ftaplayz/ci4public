<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    protected $mustache;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger){
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
        $this->mustache = new \Mustache_Engine(['loader' => new \Mustache_Loader_FilesystemLoader(APPPATH . '/views')]);
    }

    protected function loadDefaultView(array $mainContent, array $headerContent = ['title' => 'Title'], string $menu = 'comuns/menu'): string{
        $renderThis = $this->mustache->render('comuns/header', $headerContent);
        if(!empty($menu))
            $renderThis .= view($menu);
        if(!empty($mainContent['page']))
            $renderThis .= view($mainContent['page'], !empty($mainContent['data']) && is_array($mainContent['data']) ? $mainContent['data'] : []);
        $renderThis .= view('comuns/footer');
        return $renderThis;
    }

    protected function isLoggedIn(){
        $session = session();
        if(!$session->has('userdata'))
            return false;
        $utilizador = unserialize($session->get('userdata'));
        $userBd = model(\App\Models\Utilizador::class)->findUserById($utilizador->id);
        return $utilizador->token == $userBd->token;
    }
}
