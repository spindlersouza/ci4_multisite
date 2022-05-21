<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\Back\SiteModel;
use App\Models\Back\ProdutosCategoriasModel;
use App\Models\Back\ProdutosSubcategoriasModel;
use App\Controllers\Front\Carrinho;

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

    protected $buscaProdutos;
    protected $carrinhoTopo;
    protected $carrinhoItensTopo;
    protected $menuCategorias;
    protected $menuSubCategorias;

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
        $cat = new ProdutosCategoriasModel();
        $this->menuCategorias = $cat->select('produtos_categorias.id, produtos_categorias.nome, produtos_categorias.slug, produtos_categorias.imagem')
                ->distinct('produtos_categorias.nome')
                ->join('produtos_subcategorias', 'produtos_subcategorias.produtos_categorias_id = produtos_categorias.id')
                ->where('produtos_categorias.site_id', SITEENABLED)
                ->get()
                ->getResult('array');
        $subcat = new ProdutosSubcategoriasModel();
        $rsSubcat = $subcat->select('id, produtos_categorias_id, nome, slug, imagem')->where('site_id', SITEENABLED)->get()->getResult('array');
        foreach ($rsSubcat as $scat) {
            $this->menuSubCategorias[$scat['produtos_categorias_id']][] = $scat;
        }
        $this->carrinhoTopo = ['subtotal' => 0, 'quantidade' => 0];
        $this->carrinhoItensTopo = [];

        if (isset($_COOKIE['cart']) && $_COOKIE['cart'] != '') {
            $carrinho = new Carrinho();
            $rsCarrinho = $carrinho->getCarrinho();
            
            if (is_array($rsCarrinho['itens'])) {
                $rsCarrinho['carrinho']['quantidade'] = count($rsCarrinho['itens']);
            } else {
                $rsCarrinho['carrinho']['quantidade'] = 0;
            }
            $this->carrinhoTopo = $rsCarrinho['carrinho'];
            $this->carrinhoItensTopo = $rsCarrinho['itens'];
        }
        // Preload any models, libraries, etc, here.
        // E.g.: $this->session = \Config\Services::session();
    }

}
