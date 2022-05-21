<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;
use App\Models\Back\SiteModel;
use App\Models\Back\PaginasModel;
use App\Models\Back\EstadoModel;
use App\Models\Back\CidadeModel;
use App\Models\Back\ProdutosModel;
use App\Models\Back\ProdutosValorAtributosModel;
use App\Models\Front\CarrinhoModel;
use App\Models\Front\CarrinhoItensModel;
use App\Models\Front\ClientesModel;

class MeusPedidos extends BaseController {

    protected $sites;
    protected $paginas;
    protected $carrinho;
    protected $carrinhoItens;
    protected $cliente;
    protected $produtos;
    protected $produtosValor;
    protected $cidade;
    protected $estado;
    protected $data;

    public function __construct() {
        helper('cookie');
        $this->sites = New SiteModel();
        $this->paginas = New PaginasModel();
        $this->carrinho = New CarrinhoModel();
        $this->carrinhoItens = New CarrinhoItensModel();
        $this->cliente = new ClientesModel();
        $this->produtos = new ProdutosModel();
        $this->produtosValor = new ProdutosValorAtributosModel();
        $this->cidade = new CidadeModel();
        $this->estado = new EstadoModel();

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
            return redirect()->to('/login');
        }
        $this->data['menus'] = $this->menuCategorias;
        $this->data['submenus'] = $this->menuSubCategorias;
        $this->data['carrinhoTopo'] = $this->carrinhoTopo;
        $this->data['carrinhoItensTopo'] = $this->carrinhoItensTopo;
        $pedidos = $this->carrinho->where(['cliente_id' => session('cliente_id'), 'pagamento_status !=' => ''])->get()->getResult('array');
        $pedidoItens = [];
        foreach ($pedidos as $pedido) {
            
            $rsPedido = $this->carrinhoItens->where(['carrinho_id' => $pedido['id']])->get()->getResult('array');
            
            foreach ($rsPedido as $item) {
                
                $rsProd = $this->produtos->select('nome, referencia')->where(['id' =>$item['produtos_id']])->first();
                
                $pedidoItens[$pedido['id']][] = [
                    'produto_nome' => $rsProd['nome'],
                    'produto_referencia' => $rsProd['referencia'],
                    'produto_cor' => $this->produtosValor->select('valor')->where(['id'=> $item['cor_atributo_id']])->first()['valor'],
                    'produto_tamanho' => $this->produtosValor->select('valor')->where(['id'=> $item['tamanho_atributo_id']])->first()['valor'],
                    'quantidade' => $item['quantidade'],
                    'valor' => $item['valor'],
                    'subtotal' => $item['total'],
                    
                ];
            }
        }
        $this->data['pedidos'] = $pedidos;
        $this->data['pedidoItens'] = $pedidoItens;

        return view('Front/MeusPedidos/index', $this->data);
    }

}
