<?php

namespace App\Controllers\Back;

use App\Controllers\BaseController;
use App\Models\Back\SiteModel;
use App\Models\Back\CupomModel;

class Cupom extends BaseController {

    protected $cupom;
    protected $data;
    protected $sites;

    public function __construct() {
        helper(['url', 'form']);
        $this->cupom = new CupomModel();
        $this->sites = new SiteModel();
        $sites = $this->sites->whereIn('id', ['1', '2', '3'])->get()->getResult('array');
        foreach ($sites as $st) {
            $this->data['sites'][$st['id']] = $st;
        }
    }

    public function index() {
        $this->data['cupons'] = $this->cupom->get()->getResult('array');
        echo view('Back/Cupom/index', $this->data);
    }

    public function cadastro($id = null) {
        if ($id) {
            $this->data['result'] = $this->cupom->where('id', $id)->first();
            $this->data['result']['data_inicio'] = implode('/', array_reverse(explode('-', $this->data['result']['data_inicio'])));
            $this->data['result']['data_fim'] = implode('/', array_reverse(explode('-', $this->data['result']['data_fim'])));
        }
        $this->data['sites'] = $this->sites->whereIn('id', ['1', '2', '3'])->get()->getResult('array');
        echo view('Back/Cupom/cadastro', $this->data);
    }

    function editAtivo(){
        $cupom = $this->cupom->where('id', $this->request->getPost('col'))->first();
        $cupom['ativo'] = $this->request->getPost('ativo');
        $this->cupom->save($cupom);
    }
    
        
    public function save() {
        $values = [
            'site_id' => ($this->request->getPost('site_id') == 0) ? '' : $this->request->getPost('site_id'),
            'nome' => $this->request->getPost('nome'),
            'codigo' => $this->request->getPost('codigo'),
            'tipo' => $this->request->getPost('tipo'),
            'valor' => $this->request->getPost('valor'),
            'data_inicio' => implode('-', array_reverse(explode('/', $this->request->getPost('data_inicio')))),
            'data_fim' => implode('-', array_reverse(explode('/', $this->request->getPost('data_fim')))),
            'ativo' => $this->request->getPost('ativo'),
        ];

        if ($this->request->getPost('id') != '') {
            $values['id'] = $this->request->getPost('id');
        }
        if (!$this->cupom->save($values)) {
            $this->data['validation'] = $this->cupom->errors();
            $this->data['sites'] = $this->sites->whereIn('id', ['1', '2', '3'])->get()->getResult('array');
            if ($this->request->getPost('id') != '') {
                $this->data['result'] = $this->cupom->where('id', $this->request->getPost('id'))->first();
                echo view('Back/Cupom/cadastro', $this->data);               
            }
            echo view('Back/Cupom/cadastro', $this->data);

        } else {
            return redirect()->to('admin/cupom')->with('sucesso', 'Cadastrado com sucesso');
        }
    }

}
