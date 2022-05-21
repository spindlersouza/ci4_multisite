<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;
use App\Models\Back\SiteModel;
use App\Models\Back\EstadoModel;
use App\Models\Back\CidadeModel;
use App\Models\Back\PaginasModel;
use App\Models\Front\ClientesModel;

class MinhaConta extends BaseController {

    protected $sites;
    protected $paginas;
    protected $clientes;
    protected $estado;
    protected $cidade;
    protected $data;

    public function __construct() {
        helper(['url', 'form']);
        $this->sites = new SiteModel();
        $this->paginas = new PaginasModel();
        $this->clientes = new ClientesModel();
        $this->estado = new EstadoModel;
        $this->cidade = new CidadeModel();
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

    public function index() {
        if (!session()->has('cliente_id')) {
            return redirect()->to('/login');
        }
        $this->data['cliente'] = $this->clientes->where(['id' => session('cliente_id')])->first();
        $this->data['cliente']['estado'] = $this->estado->select('nome')->where(['id' => $this->data['cliente']['estado_id']])->first()['nome'];
        $this->data['cliente']['cidade'] = $this->cidade->select('nome')->where(['id' => $this->data['cliente']['cidade_id']])->first()['nome'];
        $this->data['estado'] = $this->estado->get()->getResult('array');
        $this->data['cidade'] = $this->cidade->where(['estado_id' => $this->data['cliente']['estado_id']])->get()->getResult('array');
        $this->data['menus'] = $this->menuCategorias;
        $this->data['submenus'] = $this->menuSubCategorias;
        $this->data['carrinhoTopo'] = $this->carrinhoTopo;
        $this->data['carrinhoItensTopo'] = $this->carrinhoItensTopo;

        return view('Front/MinhaConta/index', $this->data);
    }

}
