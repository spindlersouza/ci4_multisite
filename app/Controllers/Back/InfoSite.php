<?php

namespace App\Controllers\Back;

use App\Controllers\BaseController;
use App\Models\Back\SiteModel;
use App\Models\Back\CidadeModel;
use App\Models\Back\EstadoModel;
use App\Models\Back\InfoSiteModel;

class InfoSite extends BaseController {

    protected $infosite;
    protected $estados;
    protected $cidades;
    protected $sites;
    protected $data;

    public function __construct() {
        helper(['url', 'form']);
        $this->infosite = new InfoSiteModel();
        $this->estados = new EstadoModel();
        $this->cidades = new CidadeModel();
        $this->sites = new SiteModel();
        $this->data = [
            'estados' => $this->estados->get()->getResult('array'),
            'sites' => $this->sites->get()->getResult('array'),
            'slug' => SITESLUG,
        ];
    }

    public function index() {
        $this->data['infosite'] = $this->infosite->select('informacao_site.id, site.slug AS site')->join('site', 'site.id = informacao_site.site_id')->whereIn('informacao_site.site_id', ['1', '2', '3'])->get()->getResult('array');
        echo view('Back/Infosite/index', $this->data);
    }

    public function cadastro($id) {
        $this->data['result'] = $this->infosite->where('id', $id)->first();
        $this->data['cidades'] = $this->cidades->where('estado_id', $this->data['result']['estado_id'])->get()->getResult('array');
        echo view('Back/Infosite/cadastro', $this->data);
    }

    public function save() {
        $vldt = false;
        $this->data['result'] = $this->infosite->where('id', $this->request->getPost('id'))->first();
        $this->data['cidades'] = $this->cidades->where('estado_id', $this->data['result']['estado_id'])->get()->getResult('array');

        $pathFiles = ROOTPATH . 'public/upload/infosite';
        $values = [
            'id' => $this->request->getPost('id'),
            'nome' => $this->request->getPost('nome'),
            'logo' => $this->request->getPost('logo'),
            'banner_link' => $this->request->getPost('banner_link'),
            'mapa' => $this->request->getPost('mapa'),
            'site_id' => $this->request->getPost('site_id'),
            'facebook' => $this->request->getPost('facebook'),
            'instagram' => $this->request->getPost('instagram'),
            'twitter' => $this->request->getPost('twitter'),
            'linkedin' => $this->request->getPost('linkedin'),
            'youtube' => $this->request->getPost('youtube'),
            'email' => $this->request->getPost('email'),
            'telefone' => $this->request->getPost('telefone'),
            'whatsapp' => $this->request->getPost('whatsapp'),
            'cep' => $this->request->getPost('cep'),
            'estado_id' => $this->request->getPost('estado_id'),
            'cidade_id' => $this->request->getPost('cidade_id'),
            'bairro' => $this->request->getPost('bairro'),
            'endereco' => $this->request->getPost('endereco'),
            'numero' => $this->request->getPost('numero'),
            'complemento' => $this->request->getPost('complemento')
        ];

        foreach ($this->request->getFiles() as $k => $file) {
            if ($file->getName() != '') {
                $files[$k]['file'] = $file;
                $files[$k]['dim'] = \Config\Services::image()->withFile($file)->getWidth() . 'x' . \Config\Services::image()->withFile($file)->getHeight();
                $files[$k]['name'] = $file->getRandomName();
            }
        }
        if (isset($files['logo'])) {
            if ($files['logo']['dim'] != '200x70') {
                $this->data['logo_dim'] = 'Banner fora das dimenções aceitas ' . $files['logo']['dim'];
                $vldt = true;
            }
            if (!$files['logo']['file']->move($pathFiles, $files['logo']['name'])) {
                $this->data['logo_dim'] = 'Não foi possível salvar o arquivo!!';
                $vldt = true;
            }
            $values['logo'] = $files['logo']['name'];
        }
        if (isset($files['banner_link'])) {
            if ($files['banner_link']['dim'] != '950x700') {
                $this->data['banner_link_dim'] = 'Banner mobile fora das dimenções aceitas ' . $files['banner_link']['dim'];
                $vldt = true;
            }

            if (!$files['banner_link']['file']->move($pathFiles, $files['banner_link']['name'])) {
                $this->data['banner_link_dim'] = 'Não foi possível salvar o arquivo!!';
                $vldt = true;
            }
            $values['banner_link'] = $files['banner_link']['name'];
        }
        if ($vldt) {
            if (isset($files['logo'])) {
                if (is_file($pathFiles . $files['logo']['name'])) {
                    unlink($pathFiles . $files['logo']['name']);
                }
            }
            if (isset($files['banner_link'])) {
                if (is_file($pathFiles . $files['banner_link']['name'])) {
                    unlink($pathFiles . $files['banner_link']['name']);
                }
            }
            echo view('Back/Infosite/cadastro', $this->data);
            exit();
        }

        $query = $this->infosite->save($values);
        if (!$query) {
            
            echo view('Back/Infosite/cadastro', $this->data);
            exit();
//            return redirect()->back()->with('erro', 'Erro ao cadastrar');
        } else {
            return redirect()->to('admin/infosite')->with('sucesso', 'Cadastrado com sucesso');
        }
    }

}
