<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;
use App\Models\Back\SiteModel;
use App\Models\Back\PaginasModel;
use App\Models\Back\ProdutosModel;
use App\Models\Back\ProdutosAtributosModel;
use App\Models\Front\CarrinhoModel;
use App\Models\Front\CarrinhoItensModel;
use App\Models\Front\ClientesModel;
use App\Controllers\Api\Frenet;

class Pagamento extends BaseController {

    protected $sites;
    protected $paginas;
    protected $carrinho;
    protected $carrinhoItens;
    protected $produtos;
    protected $atributos;
    protected $frenet;
    protected $cliente;
    protected $data;

    public function __construct() {
        helper('cookie');
        $this->sites = New SiteModel();
        $this->paginas = New PaginasModel();
        $this->carrinho = New CarrinhoModel();
        $this->carrinhoItens = New CarrinhoItensModel();
        $this->produtos = New ProdutosModel();
        $this->atributos = New ProdutosAtributosModel();
        $this->frenet = new Frenet();
        $this->cliente = new ClientesModel();

        foreach ($this->sites->select('site, slug')->get()->getResult('array') as $row) {
            $rsSites[$row['slug']] = 'http://' . $row['site'];
        }

        $this->data = [
            'site' => SITESLUG,
            SITESLUG => 'active',
            'linksite' => $rsSites,
            'news' => $this->paginas->select('texto')->where('slug', 'news')->where('site_id', SITEENABLED)->first(),
            'menus' => $this->menuCategorias,
        ];
    }

    public function index() {
        if (!session()->has('cliente_id')) {
            session()->set('origem_link', '/pagamento');
            return redirect()->to('/login');
        }

        $pagamento = $this->carrinho->where('id', $_COOKIE['cart'])->first();
        $pagamento['cliente_id'] = session('cliente_id');
        $pagamento['desconto'] = $pagamento['desconto'] ?? 0;
        $pagamento['total'] = $pagamento['subtotal'] + $pagamento['frete'] - $pagamento['desconto'];
        $this->carrinho->save($pagamento);
        $this->data['menus'] = $this->menuCategorias;
        $this->data['submenus'] = $this->menuSubCategorias;
        $this->data['carrinhoTopo'] = $this->carrinhoTopo;
        $this->data['carrinhoItensTopo'] = $this->carrinhoItensTopo;
        $this->data['cliente'] = $this->cliente->where(['id' => session('cliente_id')])->first();
        $this->data['pagamento'] = $pagamento;
        
//        dd($this->data);
        return view('Front/Pagamento/index', $this->data);
    }

}
