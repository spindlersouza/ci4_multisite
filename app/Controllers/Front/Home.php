<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;
use App\Models\Back\SiteModel;
use App\Models\Back\PaginasModel;
use App\Models\Back\ProdutosModel;
use App\Models\Back\BannerModel;
use App\Models\Back\TopicosModel;

class Home extends BaseController {

    protected $sites;
    protected $paginas;
    protected $produtos;
    protected $banner;
    protected $topicos;
    protected $data;

    public function __construct() {
        $this->sites = New SiteModel();
        $this->paginas = New PaginasModel();
        $this->produtos = New ProdutosModel();
        $this->banner = New BannerModel();
        $this->topicos = New TopicosModel();

        foreach ($this->sites->select('site, slug')->get()->getResult('array') as $row) {
            $rsSites[$row['slug']] = 'http://' . $row['site'];
        }

        $this->data = [
            'site' => SITESLUG,
            SITESLUG => 'active',
            'linksite' => $rsSites,
            'news' => $this->paginas->select('texto')->where('slug', 'news')->where('site_id', SITEENABLED)->first(),
            'menu' => $this->menuCategorias,
        ];
    }

    public function index() {
        session()->set('origem_link', '/');
        $this->data['banners_topo'] = $this->banner->getBannerBySiteId(SITEENABLED, 1);
        $this->data['banners_meio'] = $this->banner->getBannerBySiteId(SITEENABLED, 2, 1);
        $this->data['banners_baixo'] = $this->banner->getBannerBySiteId(SITEENABLED, 3, 1);
        $this->data['banners_baixo_rodape'] = $this->banner->getBannerBySiteId(SITEENABLED, 4, 2);
        $this->data['topicos'] = $this->topicos->where('site_id', SITEENABLED)->get()->getResult('array');
        $this->data['produtos_destaque'] = $this->produtos
                        ->select('produtos.nome, produtos.imagem, produtos.preco, produtos.promo, produtos.preco_rev, produtos.promo_rev, produtos.altura, produtos.largura, produtos.comprimento, '
                                . 'produtos_categorias.slug AS categoria, produtos_subcategorias.slug AS subcategoria, produtos.slug')
                        ->join('produtos_categorias', 'produtos_categorias.id=produtos.produtos_categorias_id')
                        ->join('produtos_subcategorias', 'produtos_subcategorias.id=produtos.produtos_subcategorias_id')
//                        ->where(['produtos.site_id' => SITEENABLED, 'produtos.promo !=' => '0.00'])
                        ->where(['produtos.site_id' => SITEENABLED])
                        ->orderBy('produtos.nome', 'RANDOM')->limit(12)
                        ->get()->getResult('array');

        $this->data['produtos_recomendamos'] = $this->produtos
                        ->select('produtos.nome, produtos.imagem, produtos.preco, produtos.promo, produtos.preco_rev, produtos.promo_rev, produtos.altura, produtos.largura, produtos.comprimento, '
                                . 'produtos_categorias.slug AS categoria, produtos_subcategorias.slug AS subcategoria, produtos.slug')
                        ->join('produtos_categorias', 'produtos_categorias.id=produtos.produtos_categorias_id')
                        ->join('produtos_subcategorias', 'produtos_subcategorias.id=produtos.produtos_subcategorias_id')
                        ->where('produtos.site_id', SITEENABLED)
                        ->orderBy('produtos.nome', 'RANDOM')->limit(12)
                        ->get()->getResult('array');
        $this->data['produtos_vendidos'] = $this->produtos
                        ->select('produtos.nome, produtos.imagem, produtos.preco, produtos.promo, produtos.preco_rev, produtos.promo_rev, produtos.altura, produtos.largura, produtos.comprimento, '
                                . 'produtos_categorias.slug AS categoria, produtos_subcategorias.slug AS subcategoria, produtos.slug')
                        ->join('produtos_categorias', 'produtos_categorias.id=produtos.produtos_categorias_id')
                        ->join('produtos_subcategorias', 'produtos_subcategorias.id=produtos.produtos_subcategorias_id')
                        ->where('produtos.site_id', SITEENABLED)
                        ->orderBy('produtos.nome', 'RANDOM')->limit(12)
                        ->get()->getResult('array');
        $this->data['menus'] = $this->menuCategorias;
        $this->data['submenus'] = $this->menuSubCategorias;
        $this->data['carrinhoTopo'] = $this->carrinhoTopo;
        $this->data['carrinhoItensTopo'] = $this->carrinhoItensTopo;

//        dd($this->data);
        return view('Front/Home/' . SITESLUG, $this->data);
    }

}
