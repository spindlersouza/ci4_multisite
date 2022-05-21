<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;
use App\Models\Back\SiteModel;
use App\Models\Back\CidadeModel;
use App\Models\Back\EstadoModel;
use App\Models\Back\PaginasModel;
use App\Models\Back\LojasModel;

class NossasLojas extends BaseController {

    protected $lojas;
    protected $estados;
    protected $cidades;
    protected $sites;
    protected $paginas;
    protected $data;

    public function __construct() {
        helper(['url', 'form']);
        $this->lojas = new LojasModel();
        $this->estados = new EstadoModel();
        $this->cidades = new CidadeModel();
        $this->sites = new SiteModel();
        $this->paginas = new PaginasModel();

        foreach ($this->sites->select('site, slug')->get()->getResult('array') as $row) {
            $rsSites[$row['slug']] = 'http://' . $row['site'];
        }

        $this->data = [
            'site' => SITESLUG,
            SITESLUG => 'active',
            'linksite' => $rsSites,
            'paginas' => $this->paginas->where('slug', 'nossas-lojas')->where('site_id', SITEENABLED)->first(),
            'news' => $this->paginas->where('slug', 'news')->where('site_id', SITEENABLED)->first(),
        ];
    }

    public function index() {
        $this->data['menus'] = $this->menuCategorias;
        $this->data['submenus'] = $this->menuSubCategorias;
        $this->data['carrinhoTopo'] = $this->carrinhoTopo;
        $this->data['carrinhoItensTopo'] = $this->carrinhoItensTopo;

        $this->data['lojas'] = $this->lojas->select('lojas.id, lojas.localizacao, lojas.telefone, lojas.whatsapp, cidade.nome AS cidade, estado.uf AS uf')->
                        join('cidade', 'cidade.id = lojas.cidade_id')->
                        join('estado', 'estado.id = lojas.estado_id')->
                        where('site_id', SITEENABLED)->
                        get()->getResult('array');

        return view('Front/NossasLojas/index', $this->data);
    }

}
