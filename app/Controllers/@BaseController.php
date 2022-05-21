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
class BaseController extends Controller {

    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        // E.g.: $this->session = \Config\Services::session();
    }

    public function enviaemail() {
        $cfg = new ConfiguracaoModel();
        $config = $cfg->where('site_id', '4')->first();
        $configs['protocol'] = 'smtp';
        $configs['SMTPHost'] = $config['email_smtp'];
        $configs['SMTPPort'] = $config['email_smtp_porta'];
        $configs['smtp_timeout'] = '7';
        $configs['SMTPUser'] = $config['email_usuario'];
        $configs['SMTPPass'] = $config['email_senha'];
        $configs['charset'] = 'utf-8';
        $configs['newline'] = "\r\n";
        $configs['mailtype'] = 'html';
        $configs['validation'] = FALSE;
        $email = new \CodeIgniter\Email\Email($configs);
        $email->setFrom($config['email_usuario'], 'Teste Contato');
        $email->setTo('spindlersouza@gmail.com');
        $email->setSubject('TESTE');
        $email->setMessage('TESTE DE ENVIO');
        if ($this->request->getFile('arquivos')) {
            //TESTAR MAIS RENOMEANDO ARQUIVO 
            //TMP SAVE
            $file = $this->request->getFile('arquivos');
            $email->attach($file->getName());
        }
        if (!$email->send()) {
            dd($email->printDebugger());
        }
    }

}
