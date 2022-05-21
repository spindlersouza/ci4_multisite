<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;
use App\Models\Back\SiteModel;
use App\Models\Back\PaginasModel;

class PoliticaPrivacidade extends BaseController {

    protected $sites;
    protected $paginas;
    protected $data;

    public function __construct() {
        helper(['url', 'form']);
        $this->sites = new SiteModel();
        $this->paginas = new PaginasModel();

        foreach ($this->sites->select('site, slug')->get()->getResult('array') as $row) {
            $rsSites[$row['slug']] = 'http://' . $row['site'];
        }

        $this->data = [
            'site' => SITESLUG,
            SITESLUG => 'active',
            'linksite' => $rsSites,
            'paginas' => $this->paginas->where('slug', 'politica-privacidade')->where('site_id', SITEENABLED)->first(),
            'news' => $this->paginas->where('slug', 'news')->where('site_id', SITEENABLED)->first(),
        ];
    }

    public function index() {
        $this->data['menus'] = $this->menuCategorias;
        $this->data['submenus'] = $this->menuSubCategorias;
        $this->data['carrinhoTopo'] = $this->carrinhoTopo;
        $this->data['carrinhoItensTopo'] = $this->carrinhoItensTopo;

        return view('Front/PoliticaPrivacidade/index', $this->data);
    }

}
