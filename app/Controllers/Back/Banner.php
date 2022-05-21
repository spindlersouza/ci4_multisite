<?php

namespace App\Controllers\Back;

use App\Controllers\BaseController;
use App\Models\Back\BannerModel;
use App\Models\Back\SiteModel;
use App\Libraries\Hash;

class Banner extends BaseController {

    protected $site;
    protected $banner;

    public function __construct() {
        helper(['url', 'form']);
        $this->banner = new BannerModel();
        $this->site = new SiteModel();
    }

    public function index() {
        $data['banners'] = $this->banner->get()->getResult('array');
        echo view('Back/Banner/index', $data);
    }

    public function cadastro($id = null) {
        if ($id) {
            $data['result'] = $this->banner->where('id', $id)->first();
        }
        $sites = new SiteModel();
        $data['tipo'] = 'Cadastrar';
        $data['sites'] = $this->site->whereIn('id', ['1', '2', '3'])->get()->getResult('array');
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
                if ($files['banner']['dim'] != '1920x650') {
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

    public function indexTipos($tipo_id) {
        $data['banners'] = $this->banner->where(['tipo_id' => $tipo_id, 'deleted_at' => null])->get()->getResult('array');
        $data['tipo_id'] = $tipo_id;
        echo view('Back/Banner/indexTipos', $data);
    }

    public function cadastroTipos($tipo_id, $id = null) {
        if ($id) {
            $data['result'] = $this->banner->where('id', $id)->first();
        }
        $data['tipo'] = 'Cadastrar';
        $data['tipo_id'] = $tipo_id;
        $data['sites'] = $this->site->whereIn('id', ['1', '2', '3'])->get()->getResult('array');
        echo view('Back/Banner/cadastroTipos', $data);
    }

    public function saveTipos() {
        $data['tipo'] = 'Cadastrar';
        $data['tipo_id'] = $this->request->getPost('tipo_id');
        $data['sites'] = $this->site->get()->getResult('array');

        $tipo_id = $this->request->getPost('tipo_id');
        $validation = true;
        if ($this->request->getPost('id') == '') {
            $rules = [
                'banner' => [
                    'rules' => 'is_image[banner]|max_size[banner,2048]',
                    'errors' => [
                        'is_image' => 'Tipo de arquivo não permitido',
                        'max_size' => 'Arquivo muito grande',
                    ]
                ],
                'banner_mobile' => [
                    'rules' => 'is_image[banner_mobile]|max_size[banner_mobile,2048]',
                    'errors' => [
                        'is_image' => 'Tipo de arquivo não permitido',
                        'max_size' => 'Arquivo muito grande',
                    ]
                ]
            ];
            $validation = $this->validate($rules);
        }


        if (!$validation) {
            $data['tipo'] = 'validando';
            $data['validation'] = $this->validator;
            echo view('Back/Banner/cadastroTipos', $data);
        } else {

            $vldt = false;
            $pathBanners = ROOTPATH . 'public/upload/banner';
            $tmpPathBanners = ROOTPATH . 'public/upload/banner/tmp';
            $files = array();
            $values = [
                'nome' => $this->request->getPost('nome'),
                'dtini' => $this->request->getPost('data_inicio') ?? '',
                'dtfim' => $this->request->getPost('data_fim') ?? '',
                'link' => $this->request->getPost('link') ?? '',
                'ativo' => $this->request->getPost('ativo'),
                'site_id' => ($this->request->getPost('site_id') == '') ? null : $this->request->getPost('site_id'),
                'tipo_id' => $this->request->getPost('tipo_id') ?? '',
            ];

            foreach ($this->request->getFiles() as $k => $file) {
                if ($file->getName() != '') {
                    $files[$k]['file'] = $file;
                    $files[$k]['dim'] = \Config\Services::image()->withFile($file)->getWidth() . 'x' . \Config\Services::image()->withFile($file)->getHeight();
                    $files[$k]['name'] = $file->getRandomName();
                    $file->move($tmpPathBanners, $files[$k]['name']);
                }
            }

            if (isset($files['banner'])) {
                if ($values['tipo_id'] == '4') {

                    $image = \Config\Services::image()->withFile($tmpPathBanners . '/' . $files['banner']['name']);
                    if (($image->getWidth() < 949 xor $image->getHeight() < 699)) {
                        $data['banner_dim'] = 'Banner fora das dimenções aceitas1' . $files['banner']['dim'];
                        $vldt = true;
                    } else {
                        $image->fit(950, 700, 'center');
                        if (!$image->save($pathBanners . '/' . $files['banner']['name'])) {
                            $data['banner_dim'] = 'Não foi possível salvar o arquivo!!';
                            $vldt = true;
                        }
                    }
                } else {

                    $image = \Config\Services::image()->withFile($tmpPathBanners . '/' . $files['banner']['name']);
                    if (($image->getWidth() < 1900 xor $image->getHeight() < 649)) {
                        $data['banner_dim'] = 'Banner fora das dimenções aceitas1' . $files['banner']['dim'];
                        $vldt = true;
                    } else {
                        $image->fit(1920, 650, 'center');
                        if (!$image->save($pathBanners . '/' . $files['banner']['name'])) {
                            $data['banner_dim'] = 'Não foi possível salvar o arquivo!!';
                            $vldt = true;
                        }
                    }
                }
                $values['banner'] = $files['banner']['name'];
                unlink($tmpPathBanners . '/' . $files['banner']['name']);
            }
            if (isset($files['banner_mobile'])) {
                $image = \Config\Services::image()->withFile($tmpPathBanners . '/' . $files['banner_mobile']['name']);
                if (($image->getWidth() < 599 xor $image->getHeight() < 599)) {
                    $data['banner_dim'] = 'Banner fora das dimenções aceitas' . $files['banner_mobile']['dim'];
                    $vldt = true;
                } else {
                    $image->fit(600, 600, 'center');
                    if (!$image->save($pathBanners . '/' . $files['banner_mobile']['name'])) {
                        $data['banner_dim'] = 'Não foi possível salvar o arquivo!!';
                        $vldt = true;
                    }
                }
                unlink($tmpPathBanners . '/' . $files['banner_mobile']['name']);
                $values['banner_mobile'] = $files['banner_mobile']['name'];
            }
            if ($vldt) {
                if (isset($files['banner']) && is_file($pathBanners . $files['banner']['name'])) {
                    unlink($tmpPathBanners . '/' . $files['banner']['name']);
                }
                if (isset($files['banner_mobile']) && is_file($pathBanners . $files['banner_mobile']['name'])) {
                    unlink($tmpPathBanners . '/' . $files['banner_mobile']['name']);
                }
                echo view('Back/Banner/cadastroTipos', $data);
                exit();
            }

            if ($this->request->getPost('id') != '') {
                $values['id'] = $this->request->getPost('id');
            }
            $query = $this->banner->save($values);
            if (!$query) {
                return redirect()->back()->with('erro', 'Erro ao cadastrar');
            } else {
                return redirect()->to('admin/banner/indexTipos/' . $tipo_id)->with('sucesso', 'Cadastrado com sucesso');
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
    public function delete($id, $tipo_id) {
        $this->banner->delete(['id' => $id]);
        return redirect()->to('admin/banner/indexTipos/' . $tipo_id)->with('sucesso', 'Excluido com sucesso');
        
    }

}
