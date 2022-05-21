<?php

namespace App\Controllers\Back;

use App\Controllers\BaseController;
use App\Models\Back\SiteModel;
use App\Models\Back\FreteGratisModel;

class FreteGratis extends BaseController {

    protected $fretegratis;
    protected $sites;
    protected $data;

    public function __construct() {
        helper(['url', 'form']);
        $this->fretegratis = new FreteGratisModel();
        $this->sites = new SiteModel();
        $this->data = [];
    }

    public function index() {
        $this->data['fretes'] = $this->fretegratis->select('frete_gratis.id, frete_gratis.valor, frete_gratis.site_id, site.slug AS site')
                        ->join('site', 'site.id = frete_gratis.site_id')
                        ->get()->getResult('array');
        echo view('Back/FreteGratis/index', $this->data);
    }

    public function save() {
        $valor = ($this->request->getPost('valor') == '' ? '0,00' : $this->request->getPost('valor'));
        $values = [
            'id' => $this->request->getPost('id'),
            'valor' => $valor,
            'site_id' => $this->request->getPost('site_id'),
        ];

        if ($this->fretegratis->save($values)) {
            echo json_encode(['erro' => 'false', 'msg' => 'Valor Atualizado com sucesso']);
        } else {
            echo json_encode(['erro' => 'true', 'msg' => 'Valor não foi atualizado, por favor tente mais tarde']);
        }
    }

}
