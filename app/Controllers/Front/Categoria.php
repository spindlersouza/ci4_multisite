<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;
use App\Models\Back\SiteModel;
use App\Models\Back\PaginasModel;
use App\Models\Back\ProdutosModel;
use App\Models\Back\ProdutosCategoriasModel;
use App\Models\Back\ProdutosSubcategoriasModel;

class Categoria extends BaseController {

    protected $sites;
    protected $paginas;
    protected $produtos;
    protected $categorias;
    protected $subcategorias;
    protected $data;

    public function __construct() {
        helper(['url', 'form']);
        $this->sites = new SiteModel();
        $this->paginas = new PaginasModel();
        $this->produtos = new ProdutosModel();
        foreach ($this->sites->select('site, slug')->get()->getResult('array') as $row) {
            $rsSites[$row['slug']] = 'http://' . $row['site'];
        }

        $this->data = [
            'site' => SITESLUG,
            SITESLUG => 'active',
            'linksite' => $rsSites,
            'paginas' => $this->paginas->where('slug', 'duvidas-frequentes')->where('site_id', SITEENABLED)->first(),
            'news' => $this->paginas->where('slug', 'news')->where('site_id', SITEENABLED)->first(),
        ];
    }

    public function categoria($categ) {
        session()->set('origem_link', '/' . $categ);

        $this->data['menus'] = $this->menuCategorias;
        $this->data['submenus'] = $this->menuSubCategorias;
        $this->data['carrinhoTopo'] = $this->carrinhoTopo;
        $this->data['carrinhoItensTopo'] = $this->carrinhoItensTopo;

        $this->data['produtos'] = $this->produtos
                        ->select('produtos.nome, produtos.imagem, produtos.preco, produtos.promo, produtos.preco_rev, produtos.promo_rev, produtos.altura, produtos.largura, produtos.comprimento, '
                                . 'produtos_categorias.slug AS categoria, produtos_subcategorias.slug AS subcategoria, produtos.slug')
                        ->join('produtos_categorias', 'produtos_categorias.id=produtos.produtos_categorias_id')
                        ->join('produtos_subcategorias', 'produtos_subcategorias.id=produtos.produtos_subcategorias_id')
                        ->where('produtos_categorias.slug', $categ)
                        ->where('produtos.site_id', SITEENABLED)
                        ->get()->getResult('array');

        return view('Front/Categoria/index', $this->data);
    }

    public function subcategoria($categ, $subcateg) {
        session()->set('origem_link', '/' . $categ . '/' . $subcateg);
        $this->data['menus'] = $this->menuCategorias;
        $this->data['submenus'] = $this->menuSubCategorias;
        $this->data['carrinhoTopo'] = $this->carrinhoTopo;
        $this->data['carrinhoItensTopo'] = $this->carrinhoItensTopo;

        $this->data['produtos'] = $this->produtos
                        ->select('produtos.nome, produtos.imagem, produtos.preco, produtos.promo, produtos.preco_rev, produtos.promo_rev, produtos.altura, produtos.largura, produtos.comprimento, '
                                . 'produtos_categorias.slug AS categoria, produtos_subcategorias.slug AS subcategoria, produtos.slug')
                        ->join('produtos_categorias', 'produtos_categorias.id=produtos.produtos_categorias_id')
                        ->join('produtos_subcategorias', 'produtos_subcategorias.id=produtos.produtos_subcategorias_id')
                        ->where('produtos_categorias.slug', $categ)
                        ->where('produtos_subcategorias.slug', $subcateg)
                        ->where('produtos.site_id', SITEENABLED)
                        ->get()->getResult('array');

        return view('Front/Categoria/index', $this->data);
    }

}
