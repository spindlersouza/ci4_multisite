<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;
use App\Models\Back\SiteModel;
use App\Models\Back\PaginasModel;
use App\Models\Front\ClientesModel;
use App\Models\Back\ProdutosModel;
use App\Models\Back\ProdutosAvaliacaoModel;
use App\Models\Back\ProdutosCategoriasModel;
use App\Models\Back\ProdutosSubcategoriasModel;
use App\Models\Back\ProdutosGaleriaModel;
use App\Models\Back\ProdutosAtributosModel;
use App\Models\Back\ProdutosFavoritosModel;

class Produto extends BaseController {

    protected $lojas;
    protected $estados;
    protected $cidades;
    protected $sites;
    protected $paginas;
    protected $clientes;
    protected $data;
    protected $favoritos;
    protected $produtos;
    protected $galeria;
    protected $atributos;
    protected $categorias;
    protected $subcategorias;
    protected $avaliacao;

    public function __construct() {
        helper(['url', 'Form']);
        $this->sites = new SiteModel();
        $this->paginas = new PaginasModel();
        $this->produtos = new ProdutosModel();
        $this->galeria = new ProdutosGaleriaModel();
        $this->atributos = new ProdutosAtributosModel();
        foreach ($this->sites->select('site, slug')->get()->getResult('array') as $row) {
            $rsSites[$row['slug']] = 'http://' . $row['site'];
        }

        $this->data = [
            'site' => SITESLUG,
            SITESLUG => 'active',
            'linksite' => $rsSites,
            'news' => $this->paginas->where('slug', 'news')->where('site_id', SITEENABLED)->first(),
        ];
    }

    public function index($categ, $subcateg, $produto) {
        session()->set('origem_link', '/' . $categ . '/' . $subcateg . '/' . $produto);
        $this->data['menus'] = $this->menuCategorias;
        $this->data['submenus'] = $this->menuSubCategorias;
        $this->data['carrinhoTopo'] = $this->carrinhoTopo;
        $this->data['carrinhoItensTopo'] = $this->carrinhoItensTopo;

        $this->data['produtos_relacionados'] = $this->produtos
                        ->select('produtos.id, produtos.nome, produtos.imagem, produtos.video, produtos.preco, produtos.promo, produtos.preco_rev, produtos.promo_rev, '
                                . 'produtos.altura, produtos.largura, produtos.comprimento, produtos.peso, produtos.descricao, '
                                . 'produtos_categorias.nome AS ncategoria, produtos_subcategorias.nome AS nsubcategoria, '
                                . 'produtos_categorias.slug AS categoria, produtos_subcategorias.slug AS subcategoria, '
                                . 'produtos.slug, produtos.cod_sinc, produtos.referencia')
                        ->join('produtos_categorias', 'produtos_categorias.id=produtos.produtos_categorias_id')
                        ->join('produtos_subcategorias', 'produtos_subcategorias.id=produtos.produtos_subcategorias_id')
                        ->where('produtos_categorias.slug', $categ)
                        ->orderBy('produtos.nome', 'RANDOM')->limit(12)
                        ->where('produtos.site_id', SITEENABLED)
                        ->get()->getResult('array');

        $this->data['produto'] = $this->produtos
                        ->select('produtos.id, produtos.nome, produtos.imagem, produtos.video, produtos.descricao, produtos.descricao_simplificada, '
                                . 'produtos.preco, produtos.promo, produtos.preco_rev, produtos.promo_rev, '
                                . 'produtos.altura, produtos.largura, produtos.comprimento, produtos.peso,  '
                                . 'produtos_categorias.nome AS ncategoria, produtos_subcategorias.nome AS nsubcategoria, '
                                . 'produtos_categorias.slug AS categoria, produtos_subcategorias.slug AS subcategoria, '
                                . 'produtos.slug, produtos.cod_sinc, produtos.referencia')
                        ->join('produtos_categorias', 'produtos_categorias.id=produtos.produtos_categorias_id')
                        ->join('produtos_subcategorias', 'produtos_subcategorias.id=produtos.produtos_subcategorias_id')
                        ->where('produtos_categorias.slug', $categ)
                        ->where('produtos_subcategorias.slug', $subcateg)
                        ->where('produtos.slug', $produto)
                        ->where('produtos.site_id', SITEENABLED)->first();

        $tpAtributos = $this->atributos
                        ->select('produtos_tipo_atributos.tipo, produtos_tipo_atributos.id')
                        ->distinct('produtos_tipos_atributo.tipo')
                        ->join('produtos_tipo_atributos', 'produtos_tipo_atributos.id = produtos_atributos.produtos_tipo_atributos_id')
                        ->where('produtos_atributos.produtos_id', $this->data['produto']['id'])
                        ->get()->getResult('array');

        foreach ($tpAtributos as $tpattr) {
            $this->data['atributos'][$tpattr['tipo']] = $this->atributos
                            ->select('produtos_valor_atributos.valor, produtos_valor_atributos.id, produtos_valor_atributos.imagem')
                            ->distinct('produtos_valor_atributos.valor')
                            ->join('produtos_valor_atributos', 'produtos_valor_atributos.id = produtos_atributos.produtos_valor_atributos_id')
                            ->where('produtos_atributos.produtos_id', $this->data['produto']['id'])
                            ->where('produtos_atributos.produtos_tipo_atributos_id', $tpattr['id'])
                            ->orderBy('produtos_valor_atributos.ordem', 'ASC')
                            ->get()->getResult('array');
        }
        $this->data['cor_unica'] = count($this->data['atributos']['CORES']) == 1 ? $this->data['atributos']['CORES'][0]['id'] : '';
        $this->data['tamanho_unico'] = count($this->data['atributos']['TAMANHOS']) == 1 ? $this->data['atributos']['TAMANHOS'][0]['id'] : '';
        $this->data['galeria'] = $this->galeria->select('imagem, ordem, cor')->distinct('imagem')->where('produtos_id', $this->data['produto']['id'])->orderby('cor', 'ASC')->orderby('ordem', 'ASC')->get()->getResult('array');
        $this->data['favorito'] = false;
        $this->data['produto_nota'] = 0;
        $this->data['produto_notas'] = 0;
        $this->data['produto_avaliacao'] = [
            '1' => '',
            '2' => '',
            '3' => '',
            '4' => '',
            '5' => '',
        ];
        $this->data['avaliacoes'] = [];
        if (isset($_COOKIE['favoritos'])) {
            $cc = json_decode($_COOKIE['favoritos'], true);
            $this->data['favorito'] = in_array($this->data['produto']['id'], $cc['produtos']);
        }
        return view('Front/Produto/index', $this->data);
    }

    public function addFavorito() {
        $produtos = [];
        $produtosdb = [];
        $produtoscookie = [];
        $cliente_id = session('cliente_id') ?? null;
        $id = $this->request->getPost('id');
        $produtos[] = $id;
        if (session()->has('cliente_id')) {
            $this->favoritos = new ProdutosFavoritosModel();
            foreach ($this->favoritos->where(['cliente_id' => session('cliente_id')])->get()->getResult('array') as $k => $fav) {
                $this->favoritos->delete(['id' => $fav['id']]);
                $produtos[] = $fav['produto_id'];
            }
        }
        if (isset($_COOKIE['favoritos'])) {
            $cc = json_decode($_COOKIE['favoritos'], true);
            foreach ($cc['produtos'] as $fav) {
                $produtos[] = $fav;
            }
        }

        $prods = array_unique($produtos);

        if (session()->has('cliente_id')) {
            $this->favoritos = new ProdutosFavoritosModel();
            foreach ($prods as $fav) {
                $this->favoritos->save(['cliente_id' => $cliente_id, 'site_id' => SITEENABLED, 'produto_id' => $fav]);
            }
        }

        $favoritos = json_encode(['cliente_id' => $cliente_id, 'site_id' => SITEENABLED, 'produtos' => $prods]);
        setcookie("favoritos", $favoritos, time() + 3600 * 24 * 7, "/");

        return $favoritos;
    }

    public function delFavorito() {
        $produtos = [];
        $produtosdb = [];
        $produtoscookie = [];
        $cliente_id = session('cliente_id') ?? null;
        $id = $this->request->getPost('id');
        if (session()->has('cliente_id')) {
            $this->favoritos = new ProdutosFavoritosModel();
            foreach ($this->favoritos->where(['cliente_id' => session('cliente_id')])->get()->getResult('array') as $k => $fav) {
                $this->favoritos->delete(['id' => $fav['id']]);
                if ($fav['produto_id'] != $id) {
                    $produtos[] = $fav['produto_id'];
                }
            }
        }
        if (isset($_COOKIE['favoritos'])) {
            $cc = json_decode($_COOKIE['favoritos'], true);
            foreach ($cc['produtos'] as $fav) {
                if ($fav != $id) {
                    $produtos[] = $fav;
                }
            }
        }

        $prods = array_unique($produtos);

        if (session()->has('cliente_id')) {
            $this->favoritos = new ProdutosFavoritosModel();
            foreach ($prods as $fav) {
                $this->favoritos->save(['cliente_id' => $cliente_id, 'site_id' => SITEENABLED, 'produto_id' => $fav]);
            }
        }

        $favoritos = json_encode(['cliente_id' => $cliente_id, 'site_id' => SITEENABLED, 'produtos' => $prods]);
        setcookie("favoritos", $favoritos, time() + 3600 * 24 * 7, "/");

        return $favoritos;
    }

    public function avaliacao() {
        $this->avaliacao = new ProdutosAvaliacaoModel();
        $values = [
            'cliente_id' => session('cliente_id'),
            'produtos_id' => $this->request->gePost('produto'),
            'nota' => $this->request->getPost('nota'),
            'descricao' => $this->request->getPost('descricao'),
            'ativo' => '0'
        ];
        $this->avaliacao->save($values);
        session()->setFlashdata('avaliacao', 'avaliacao');
    }

}
