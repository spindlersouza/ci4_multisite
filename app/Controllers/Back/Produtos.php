<?php

namespace App\Controllers\Back;

use App\Controllers\BaseController;
use App\Models\Back\BannerModel;
use App\Models\Back\SiteModel;
use App\Libraries\Hash;

class Produtos extends BaseController {

    protected $produtos;

    public function __construct() {
        helper(['url', 'form']);
        $this->produtos = new ProdutosModel();
    }

    public function index() {
        $banners = new BannerModel();
        $data['banners'] = $banners->get()->getResult('array');
        echo view('Back/Banner/index', $data);
    }

    public function cadastro($id = null) {
        if ($id) {
            $data['result'] = $this->banner->where('id', $id)->first();
        }
        $sites = new SiteModel();
        $data['tipo'] = 'Cadastrar';
        $data['sites'] = $sites->get()->getResult('array');
        echo view('Back/Banner/cadastro', $data);
    }

    public function save() {

        if ($this->request->getPost('id') == '') {
            $rules = [
                'nome' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Campo obrigatório',
                    ],
                ],
                'banner' => [
                    'rules' => 'uploaded[banner]|is_image[banner]|max_size[banner,2048]',
                    'errors' => [
                        'uploaded' => 'Campo Obrigatório',
                        'is_image' => 'Tipo de arquivo não permitido',
                        'max_size' => 'Arquivo muito grande',
                    ]
                ],
                'banner_mobile' => [
                    'rules' => 'uploaded[banner_mobile]|is_image[banner_mobile]|max_size[banner_mobile,2048]',
                    'errors' => [
                        'uploaded' => 'Campo Obrigatório',
                        'is_image' => 'Tipo de arquivo não permitido',
                        'max_size' => 'Arquivo muito grande',
                    ]
                ]
            ];
        } else {
            $rules = [
                'nome' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Campo obrigatório',
                    ],
                ],
            ];
        }
        $validation = $this->validate($rules);

        if (!$validation) {
            $data = ['tipo' => 'validando', 'validation' => $this->validator];
            echo view('Back/Banner/cadastro', $data);
        } else {

            $vldt = false;
            $pathBanners = ROOTPATH . 'public/upload/banner';
            $files = array();
            $values = [
                'nome' => $this->request->getPost('nome'),
                'dtini' => $this->request->getPost('data_inicio') ?? '',
                'dtfim' => $this->request->getPost('data_fim') ?? '',
                'link' => $this->request->getPost('link') ?? '',
                'ativo' => $this->request->getPost('ativo'),
                'site_id' => $this->request->getPost('site_id') ?? '',
            ];

            foreach ($this->request->getFiles() as $k => $file) {

                if ($file->getName() != '') {
                    $files[$k]['file'] = $file;
                    $files[$k]['dim'] = \Config\Services::image()->withFile($file)->getWidth() . 'x' . \Config\Services::image()->withFile($file)->getHeight();
                    $files[$k]['name'] = $file->getRandomName();
                }
            }

            if (isset($files['banner'])) {
                if ($files['banner']['dim'] != '1920x660') {
                    $data = ['banner_dim' => 'Banner fora das dimenções aceitas ' . $files['banner']['dim']];
                    $vldt = true;
                }
                if (!$files['banner']['file']->move($pathBanners, $files['banner']['name'])) {
                    $data = ['banner_dim' => 'Não foi possível salvar o arquivo!!'];
                    $vldt = true;
                }
                $values['banner'] = $files['banner']['name'];
            }
            if (isset($files['banner_mobile'])) {
                if ($files['banner_mobile']['dim'] != '600x600') {
                    $data = ['bannerMobile_dim' => 'Banner mobile fora das dimenções aceitas ' . $files['banner_mobile']['dim']];
                    $vldt = true;
                }

                if (!$files['banner_mobile']['file']->move($pathBanners, $files['banner_mobile']['name'])) {
                    $data = ['bannerMobile_dim' => 'Não foi possível salvar o arquivo!!'];
                    $vldt = true;
                }
                $values['banner_mobile'] = $files['banner_mobile']['name'];
            }
            if ($vldt) {
                if (is_file($pathBanners . $files['banner']['name'])) {
                    unlink($pathBanners . $files['banner']['name']);
                }
                if (is_file($pathBanners . $files['banner_mobile']['name'])) {
                    unlink($pathBanners . $files['banner_mobile']['name']);
                }
                echo view('Back/Banner/cadastro', $data);
                exit();
            }

            if ($this->request->getPost('id') != '') {
                $values['id'] = $this->request->getPost('id');
            }
            $query = $this->banner->save($values);
            if (!$query) {
                return redirect()->back()->with('erro', 'Erro ao cadastrar');
            } else {
                return redirect()->to('admin/banner')->with('sucesso', 'Cadastrado com sucesso');
            }
        }
    }
    
    public function editAtivo() {
        $values = [
            'ativo' => $this->request->getPost('ativo'),
            'id' => $this->request->getPost('col'),
        ];
        $this->banner->save($values);
        
    }

}
