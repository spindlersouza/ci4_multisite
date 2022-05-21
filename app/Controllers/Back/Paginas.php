<?php

namespace App\Controllers\Back;

use App\Controllers\BaseController;
use App\Models\Back\SiteModel;
use App\Models\Back\PaginasModel;

class Paginas extends BaseController {

    protected $paginas;
    protected $sites;
    protected $label;

    public function __construct() {
        helper(['url', 'form']);
        $this->paginas = new PaginasModel();
        $this->sites = new SiteModel();
        $this->label = [
            'nossas-lojas' => 'Lojas',
            'duvidas-frequentes' => 'Dúvidas Frequentes',
            'politica-privacidade' => 'Politica de Privacidade',
            'termos-uso' => 'Termos de Uso',
            'trocas-devolucoes' => 'Trocas e Devoluções',
            'news' => 'Newsletter',
        ];
    }

    public function index($slug) {
        $listPaginas = $this->paginas
                        ->select('paginas.*, site.slug AS site')
                        ->join('site', 'site.id = paginas.site_id')
                        ->where('paginas.slug', $slug)->get()->getResult('array');
        $data = [
            'labelPagina' => $this->label[$slug],
            'paginas' => $listPaginas,
        ];

        echo view('Back/Paginas/index', $data);
    }

    public function cadastro($slug, $id) {
        $listPaginas = $this->paginas
                        ->select('paginas.*, site.slug AS site')
                        ->join('site', 'site.id = paginas.site_id')
                        ->where('paginas.slug', $slug)
                        ->where('paginas.id', $id)->first();

        $data = [
            'id' => $id,
            'pagina' => $slug,
            'result' => $listPaginas,
            'site' => SITESLUG,
            'labelPagina' => $this->label[$slug]
        ];
        echo view('Back/Paginas/cadastro', $data);
    }

    public function save() {

        $vldt = false;
        $pathBanners = ROOTPATH . 'public/upload/banner';
        $files = array();
        $values = [
            'id' => $this->request->getPost('id'),
            'texto' => $this->request->getPost('texto'),
        ];

        $listPaginas = $this->paginas
                        ->select('paginas.*, site.slug AS site')
                        ->join('site', 'site.id = paginas.site_id')
                        ->where('paginas.slug', $this->request->getPost('slug'))
                        ->where('paginas.id', $this->request->getPost('id'))->first();

        $data = [
            'id' => $this->request->getPost('id'),
            'pagina' => $this->request->getPost('slug'),
            'result' => $listPaginas,
            'site' => SITESLUG,
            'labelPagina' => $this->label[$this->request->getPost('slug')],
        ];

        foreach ($this->request->getFiles() as $k => $file) {
            if ($file->getName() != '') {
                $files[$k]['file'] = $file;
                $files[$k]['dim'] = \Config\Services::image()->withFile($file)->getWidth() . 'x' . \Config\Services::image()->withFile($file)->getHeight();
                $files[$k]['name'] = $file->getRandomName();
            }
        }

        if (isset($files['banner'])) {
            if ($files['banner']['dim'] != '1920x650') {
                $data['banner_dim'] = 'Banner fora das dimenções aceitas ' . $files['banner']['dim'];
                $vldt = true;
            }
            if (!$files['banner']['file']->move($pathBanners, $files['banner']['name'])) {
                $data['banner_dim'] = 'Não foi possível salvar o arquivo!!';
                $vldt = true;
            }
            $values['banner'] = $files['banner']['name'];
        }
        if (isset($files['banner_mobile'])) {
            if ($files['banner_mobile']['dim'] != '600x600') {
                $data['bannerMobile_dim'] = 'Banner mobile fora das dimenções aceitas ' . $files['banner_mobile']['dim'];
                $vldt = true;
            }

            if (!$files['banner_mobile']['file']->move($pathBanners, $files['banner_mobile']['name'])) {
                $data['bannerMobile_dim'] = 'Não foi possível salvar o arquivo!!';
                $vldt = true;
            }
            $values['banner_mobile'] = $files['banner_mobile']['name'];
        }
        if ($vldt) {
            if (isset($files['banner'])) {
                if (is_file($pathBanners . $files['banner']['name'])) {
                    unlink($pathBanners . $files['banner']['name']);
                }
            }
            if (isset($files['banner_mobile'])) {
                if (is_file($pathBanners . $files['banner_mobile']['name'])) {
                    unlink($pathBanners . $files['banner_mobile']['name']);
                }
            }

            echo view('Back/Paginas/cadastro', $data);
            exit();
        }

        $query = $this->paginas->save($values);
        if (!$query) {
            return redirect()->back()->with('erro', 'Erro ao cadastrar');
        } else {
            return redirect()->to('admin/paginas/' . $this->request->getPost('slug'))->with('sucesso', 'Cadastrado com sucesso');
        }
    }

}
