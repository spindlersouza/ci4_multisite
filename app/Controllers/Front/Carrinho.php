<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;
use App\Models\Back\SiteModel;
use App\Models\Back\CupomModel;
use App\Models\Back\PaginasModel;
use App\Models\Back\EstadoModel;
use App\Models\Back\CidadeModel;
use App\Models\Back\ProdutosModel;
use App\Models\Back\ProdutosAtributosModel;
use App\Models\Back\ProdutosTiposAtributosModel;
use App\Models\Back\ProdutosValorAtributosModel;
use App\Models\Back\FreteGratisModel;
use App\Models\Front\CarrinhoModel;
use App\Models\Front\CarrinhoItensModel;
use App\Models\Front\ClientesModel;
use App\Controllers\Api\Frenet;

class Carrinho extends BaseController {

    protected $sites;
    protected $paginas;
    protected $cupom;
    protected $carrinho;
    protected $carrinhoItens;
    protected $produtos;
    protected $atributos;
    protected $tipoatributos;
    protected $valoratributos;
    protected $frenet;
    protected $fretegratis;
    protected $cliente;
    protected $cidade;
    protected $estado;
    protected $data;

    public function __construct() {
        helper('cookie');
        $this->sites = New SiteModel();
        $this->paginas = New PaginasModel();
        $this->carrinho = New CarrinhoModel();
        $this->carrinhoItens = New CarrinhoItensModel();
        $this->produtos = New ProdutosModel();
        $this->atributos = New ProdutosAtributosModel();
        $this->tipoatributos = New ProdutosTiposAtributosModel();
        $this->valoratributos = New ProdutosValorAtributosModel();
        $this->frenet = new Frenet();
        $this->fretegratis = new FreteGratisModel();
        $this->cliente = new ClientesModel();
        $this->cidade = new CidadeModel();
        $this->estado = new EstadoModel();

        foreach ($this->sites->select('site, slug')->get()->getResult('array') as $row) {
            $rsSites[$row['slug']] = 'http://' . $row['site'];
        }

        $this->data = [
            'site' => SITESLUG,
            SITESLUG => 'active',
            'linksite' => $rsSites,
            'fretegratis' => $this->fretegratis->select('valor')->where('site_id', SITEENABLED)->first()['valor'],
            'news' => $this->paginas->select('texto')->where(['slug' => 'news', 'site_id' => SITEENABLED])->first(),
        ];
    }

    public function index() {
        session()->set('origem_link', '/carrinho');
        if (!isset($_COOKIE['cart'])) {
            $cliente_id = session('cliente_id') ?? null;
            $val = ['clientes_id' => $cliente_id, 'site_id', SITEENABLED];
            $this->carrinho->save(['clientes_id' => $cliente_id, 'site_id' => SITEENABLED]);
            $id_carrinho = $this->carrinho->insertID();
            setcookie("cart", $id_carrinho, time() + 3600 * 24 * 7, "/");
        } else {
            $id_carrinho = $_COOKIE['cart'];
        }
        $carrinhoItens = [];
        $carrinho = $this->carrinho->where('id', $id_carrinho)->first();
        foreach ($this->carrinhoItens->where('carrinho_id', $carrinho['id'])->get()->getResult('array') as $k => $item) {
            $rsProd = $this->produtos->select('nome, referencia, imagem, altura, largura, comprimento, peso')->where('id', $item['produtos_id'])->first();
            $rsCor = $this->valoratributos->select('valor')->where(['produtos_tipo_atributos_id' => 1, 'id' => $item['cor_atributo_id']])->first();
            $rsTamanho = $this->valoratributos->select('valor')->where(['produtos_tipo_atributos_id' => 2, 'id' => $item['tamanho_atributo_id']])->first();
            $carrinhoItens[$item['id']] = [
                'id' => $item['id'],
                'produtos_id' => $item['produtos_id'],
                'produto_nome' => $rsProd['nome'],
                'produto_imagem' => $rsProd['imagem'],
                'cor' => $rsCor['valor'],
                'tamanho' => $rsTamanho['valor'],
                'quantidade' => $item['quantidade'],
                'valor' => $item['valor'],
                'subtotal' => $item['total']
            ];
        }
        $carrinho['estado'] = '';
        $carrinho['cidade'] = '';
        if (session()->has('cliente_id')) {
            $cliente = $this->cliente->select('id, cep, estado_id, cidade_id, bairro, endereco, numero, complemento')->where(['id' => session('cliente_id')])->first();
            if ($carrinho['cep'] == '') {
                $carrinho['cep'] = $cliente['cep'];
                $carrinho['estado_id'] = $cliente['estado_id'];
                $carrinho['cidade_id'] = $cliente['cidade_id'];
                $carrinho['bairro'] = $cliente['bairro'];
                $carrinho['endereco'] = $cliente['endereco'];
                $carrinho['numero'] = $cliente['numero'];
                $carrinho['complemento'] = $carrinho['complemento'] ?? $cliente['complemento'];
                $this->carrinho->save($carrinho);
            }
            $carrinho['total'] = $carrinho['subtotal'] + $carrinho['frete'];
        }
        if ($carrinho['cep'] != '') {
            $carrinho['estado'] = $this->estado->select('uf')->where(['id' => $carrinho['estado_id']])->first()['uf'];
            $carrinho['cidade'] = $this->cidade->select('nome')->where(['id' => $carrinho['cidade_id']])->first()['nome'];
        }
        $carrinho['lista_frete'] = $carrinho['cep'] != '' ? json_decode($this->frenet->getFreteCarrinho($carrinho['cep']), true) : '';
        $carrinho['total'] = $carrinho['subtotal'];
        $this->data['carrinho'] = $carrinho;
        $this->data['carrinho_itens'] = $carrinhoItens;
        $this->data['endereco'] = ($carrinho['cep'] != '');
        $this->data['estado'] = $this->estado->get()->getResult('array');
        $this->data['menus'] = $this->menuCategorias;
        $this->data['submenus'] = $this->menuSubCategorias;
        $this->data['carrinhoTopo'] = $this->carrinhoTopo;
        $this->data['carrinhoItensTopo'] = $this->carrinhoItensTopo;
        return view('Front/Carrinho/index', $this->data);
    }

    public function delProduto($id) {
        $this->carrinhoItens->delete(['id' => $id]);
    }

    public function addProduto() {
        //REFACTORY
        $id = $this->request->getPost('produtos_id');
        $qtd = $this->request->getPost('qtd');
        $cor = $this->request->getPost('cor');
        $tamanho = $this->request->getPost('tamanho');
        $cartRet = [];
        if (!isset($_COOKIE['cart'])) {
            $cliente_id = session('cliente_id') ?? null;
            $val = ['clientes_id' => $cliente_id, 'site_id', SITEENABLED];
            $this->carrinho->save(['clientes_id' => $cliente_id, 'site_id' => SITEENABLED]);
            $id_carrinho = $this->carrinho->insertID();
            setcookie("cart", $id_carrinho, time() + 3600 * 24 * 7, "/");
        } else {
            $id_carrinho = $_COOKIE['cart'];
        }

        $cep = [
            'cep' => ($_COOKIE['cep'] ?? session('cep')) ?? '',
            'frete_tipo' => ($_COOKIE['frete'] ?? session('frete')) ?? ''
        ];

        $subtotal = 0;
        $subtotal_rev = 0;
        $cartItem = [];
        $carrinho = $this->carrinho->where('id', $id_carrinho)->first();
        foreach ($this->carrinhoItens->where('carrinho_id', $carrinho['id'])->get()->getResult('array') as $k => $item) {
            $this->carrinhoItens->delete(['id' => $item['id']]);
            if ($item['produtos_id'] != $id || $item['cor_atributo_id'] != $cor || $item['tamanho_atributo_id'] != $tamanho) {
                $carrinhoItens[$item['id']]['item'] = $this->produtos->select('id, nome, referencia, imagem,altura,largura,comprimento,peso,preco,promo,preco_rev,promo_rev')->where('id', $item['produtos_id'])->first();
                $carrinhoItens[$item['id']]['qtd'] = $item['quantidade'];
                $carrinhoItens[$item['id']]['subtotal'] = (($carrinhoItens[$item['id']]['item']['promo'] > 0) ? $carrinhoItens[$item['id']]['item']['promo'] : $carrinhoItens[$item['id']]['item']['preco']) * $item['quantidade'];
                $subtotal += $carrinhoItens[$item['id']]['subtotal'];
                $cartItem = [
                    'site_id' => $carrinho['site_id'],
                    'carrinho_id' => $carrinho['id'],
                    'produtos_id' => $item['produtos_id'],
                    'cor_atributo_id' => $item['cor_atributo_id'],
                    'tamanho_atributo_id' => $item['tamanho_atributo_id'],
                    'quantidade' => $item['quantidade'],
                    'valor' => ($carrinhoItens[$item['id']]['item']['promo'] > 0) ? $carrinhoItens[$item['id']]['item']['promo'] : $carrinhoItens[$item['id']]['item']['preco'],
                    'total' => $carrinhoItens[$item['id']]['subtotal'],
                ];
                $this->carrinhoItens->save($cartItem);
                $cartItem['id'] = $this->carrinhoItens->insertID();
                $cartItem['imagem'] = $carrinhoItens[$item['id']]['item']['imagem'];
                $cartItem['nome'] = $carrinhoItens[$item['id']]['item']['nome'];
                $cartRet[] = $cartItem;
                $cartItem = [];
            }
        }
        $carrinhoItens[$id]['item'] = $this->produtos->select('id, nome, referencia, imagem,altura,largura,comprimento,peso,preco,promo,preco_rev,promo_rev')->where('id', $id)->first();
        $carrinhoItens[$id]['qtd'] = $qtd;
        $carrinhoItens[$id]['subtotal'] = (($carrinhoItens[$id]['item']['promo'] > 0) ? $carrinhoItens[$id]['item']['promo'] : $carrinhoItens[$id]['item']['preco']) * $qtd;
        $subtotal += $carrinhoItens[$id]['subtotal'];
        $cartItem = [
            'site_id' => $carrinho['site_id'],
            'carrinho_id' => $carrinho['id'],
            'produtos_id' => $id,
            'cor_atributo_id' => $cor,
            'tamanho_atributo_id' => $tamanho,
            'quantidade' => $qtd,
            'valor' => ($carrinhoItens[$id]['item']['promo'] > 0) ? $carrinhoItens[$id]['item']['promo'] : $carrinhoItens[$id]['item']['preco'],
            'total' => $carrinhoItens[$id]['subtotal'],
        ];
        $carrinho['subtotal'] = $subtotal;
        $this->carrinhoItens->save($cartItem);
        $cartItem['id'] = $this->carrinhoItens->insertID();
        $cartItem['imagem'] = $carrinhoItens[$id]['item']['imagem'];
        $cartItem['nome'] = $carrinhoItens[$id]['item']['nome'];
        $cartRet[] = $cartItem;

        if ($cep['cep'] != '' && $cep['frete_tipo'] != '') {
            $carrinho['frete'] = $this->frenet->calcFreteCarrinho($carrinhoItens, $cep['cep'], $cep['frete_tipo']);
            $carrinho['total'] = $carrinho['subtotal'] + $carrinho['frete'];
        }
        $this->carrinho->save($carrinho);
        return json_encode($cartRet);
    }

    public function addCupom() {
        $ret = ['erro' => 'cupom'];
        $codigo = $this->request->getPost('codigo');
        $this->cupom = new CupomModel();
        $cupom = $this->cupom->where(['codigo' => $codigo, 'site_id' => SITEENABLED])->first();
        if ($cupom) {
            $ret = [];
            $carrinho = $this->carrinho->where(['id' => $_COOKIE['cart'], 'site_id' => SITEENABLED])->first();
            $carrinho['cupom_id'] = $cupom['id'];
            $carrinho['cupom'] = $cupom['codigo'];
            $carrinho['cupom_valor'] = $cupom['valor'];
            $carrinho['cupom_tipo'] = $cupom['tipo'];
            $totalCarrinho = 0;
            foreach ($this->carrinhoItens->select('valor, quantidade, total')->where('carrinho_id', $carrinho['id'])->get()->getResult('array') as $k => $item) {
                $item['total'] = $item['valor'] * $item['quantidade'];
                $totalCarrinho += $item['total'];
                $this->carrinhoItens->save($item);
            }

            $carrinho['subtotal'] = $totalCarrinho;
            if ($carrinho['subtotal'] > 0) {
                $carrinho['desconto'] = (($cupom['tipo'] == 1) ? $carrinho['subtotal'] * ($cupom['valor'] / 100) : $cupom['valor']);
                $ret['desconto'] = (int) (($cupom['tipo'] == 1) ? $carrinho['subtotal'] * ($cupom['valor'] / 100) : $cupom['valor']);
                $ret['cupom_valor'] = $cupom['valor'];
                $ret['cupom_tipo'] = $cupom['tipo'];
            }

            $ret['total_produtos'] = $carrinho['subtotal'];
            if ($carrinho['cep'] != '' && $carrinho['tipo_frete'] != '') {
                $carrinho['frete'] = $this->frenet->reCalcFreteCarrinho($carrinho['cep'], $carrinho['tipo_frete']);
                $ret['tipo_frete'] = $carrinho['tipo_frete'];
                $ret['carrinho_total'] = $carrinho['subtotal'] + $carrinho['frete'];
                $carrinho['total'] = $carrinho['subtotal'] - $carrinho['desconto'] + $carrinho['frete'];
            }
            $this->carrinho->save($carrinho);
        }


        return json_encode($ret);
    }

    public function getCarrinho() {
        $subtotal = 0;
        $carrinho = $this->carrinho->where(['id' => $_COOKIE['cart'], 'site_id' => SITEENABLED])->first();
        if (empty($carrinho)) {
            setcookie('cart', null, -1, '/');
            $cartRet['carrinho'] = ['subtotal' => 0, 'quantidade' => 0];
            $cartRet['itens'] = [];
        } else {
            $cartRet['itens'] = [];
            foreach ($this->carrinhoItens->where('carrinho_id', $carrinho['id'])->get()->getResult('array') as $k => $item) {
                $produto = $this->produtos->select('id, nome, referencia, imagem, altura, largura, comprimento, peso, preco, promo')->where('id', $item['produtos_id'])->first();
                $vlProduto = ($produto['promo'] > 0) ? $produto['promo'] : $produto['preco'];
                $subtotal += $vlProduto * $item['quantidade'];
                $cartItem = [
                    'id' => $item['id'],
                    'site_id' => $carrinho['site_id'],
                    'carrinho_id' => $carrinho['id'],
                    'produtos_id' => $item['produtos_id'],
                    'cor_atributo_id' => $item['cor_atributo_id'],
                    'tamanho_atributo_id' => $item['tamanho_atributo_id'],
                    'quantidade' => $item['quantidade'],
                    'valor' => $vlProduto,
                    'total' => $vlProduto * $item['quantidade'],
                ];
                $this->carrinhoItens->save($cartItem);
                $cartItem['imagem'] = $produto['imagem'];
                $cartItem['nome'] = $produto['nome'];
                $cartRet['itens'][] = $cartItem;
                $cartItem = [];
            }
            $carrinho['ip'] = $_SERVER['REMOTE_ADDR'];
            $carrinho['subtotal'] = $subtotal;
            $this->carrinho->save($carrinho);
            $cartRet['carrinho'] = $carrinho;
        }

        return $cartRet;
    }

    public function addQuantidade() {
        $ret = [];
        $item = $this->carrinhoItens->where(['id' => $this->request->getPost('id')])->first();
        $item['quantidade'] = $this->request->getPost('quantidade');
        if ($item['quantidade'] == 0) {
            $this->carrinhoItens->delete(['id' => $item['id']]);
        } else {
            $item['total'] = $item['valor'] * $item['quantidade'];
            $ret['item_subtotal'] = $item['total'];
            $this->carrinhoItens->save($item);
        }
        $carrinho = $this->carrinho->where('id', $item['carrinho_id'])->first();
        $totalCarrinho = 0;
        foreach ($this->carrinhoItens->select('total')->where('carrinho_id', $carrinho['id'])->get()->getResult('array') as $k => $item) {
            $totalCarrinho += $item['total'];
        }

        $ret['total_produtos'] = $carrinho['subtotal'] = $totalCarrinho;
        $ret['desconto'] = 0;
        if ($carrinho['subtotal'] > 0 && $carrinho['cupom_id'] != '') {
            $carrinho['desconto'] = (($carrinho['cupom_tipo'] == 1) ? $carrinho['subtotal'] * ($carrinho['cupom_valor'] / 100) : $carrinho['cupom_valor']);
            $ret['desconto'] = (int) ($carrinho['cupom_tipo'] == 1) ? $carrinho['subtotal'] * ($carrinho['cupom_valor'] / 100) : $carrinho['cupom_valor'];
            $ret['cupom_valor'] = $carrinho['cupom_valor'];
            $ret['cupom_tipo'] = $carrinho['cupom_tipo'];
        }

        if ($carrinho['cep'] != '' && $carrinho['tipo_frete'] != '') {
            $carrinho['frete'] = $this->frenet->reCalcFreteCarrinho($carrinho['cep'], $carrinho['tipo_frete']);
            $ret['tipo_frete'] = $carrinho['tipo_frete'];
            $ret['carrinho_total'] = $carrinho['subtotal'] + $carrinho['frete'];
            $carrinho['total'] = $carrinho['subtotal'] - $carrinho['desconto'] + $carrinho['frete'];
        }
        $this->carrinho->save($carrinho);
        return json_encode($ret);
    }

    public function freteselect() {
        if (session()->has('cliente_id')) {
            session()->set('freteselect', $this->request->getPost('tipo'));
        }
        $carrinho = $this->carrinho->where(['id' => $_COOKIE['cart'], 'site_id' => SITEENABLED])->first();
        $carrinho['tipo_frete'] = $this->request->getPost('tipo');
        $carrinho['frete'] = $this->request->getPost('valor');
        $this->carrinho->save($carrinho);
    }

    public function atualizaCep() {
        $carrinho = $this->carrinho->where(['id' => $_COOKIE['cart'], 'site_id' => SITEENABLED])->first();
        $carrinho['cep'] = str_replace('-', '', $this->request->getPost('cep'));
        $carrinho['estado_id'] = $this->request->getPost('estado_id');
        $carrinho['cidade_id'] = $this->request->getPost('cidade_id');
        $carrinho['endereco'] = $this->request->getPost('endereco');
        $carrinho['bairro'] = $this->request->getPost('bairro');
        $carrinho['numero'] = $this->request->getPost('numero');
        $carrinho['complemento'] = $this->request->getPost('complemento');
        $this->carrinho->save($carrinho);
        return redirect()->to('/carrinho');
    }

}
