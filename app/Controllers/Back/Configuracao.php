<?php

namespace App\Controllers\Back;

use App\Controllers\BaseController;
use App\Models\Back\ConfiguracaoModel;
use App\Libraries\Hash;

class Configuracao extends BaseController {

    protected $configs;
    protected $data;

    public function __construct() {
        helper(['url', 'form']);
        $this->configs = new ConfiguracaoModel();
        $this->data = [
            'slug' => SITESLUG,
        ];
    }

    public function index() {
        $this->data['configs'] = $this->configs
                        ->select('configuracao.id, site.slug AS site')
                        ->join('site', 'site.id = configuracao.site_id')
                        ->whereIn('configuracao.site_id', ['1', '2', '3'])
                        ->get()->getResult('array');
        echo view('Back/Configuracao/index', $this->data);
    }

    public function cadastro($id) {
        $this->data['result'] = $this->configs->where('id', $id)->first();
        echo view('Back/Configuracao/cadastro', $this->data);
    }

    public function save() {
        $vldt = false;

        $pathFiles = ROOTPATH . 'public/upload/configs';
        $tmpPathFiles = ROOTPATH . 'public/upload/configs/tmp';
        $files = array();

        $values = [
            'id' => $this->request->getPost('id'),
            'cep_remetente' => $this->request->getPost('cep_remetente'),
            'correios_usuario' => $this->request->getPost('correios_usuario'),
            'correios_senha' => $this->request->getPost('correios_senha'),
            'pagseguro_ambiente' => $this->request->getPost('pagseguro_ambiente'),
            'pagseguro_email' => $this->request->getPost('pagseguro_email'),
            'pagseguro_token' => $this->request->getPost('pagseguro_token'),
            'frenet_chave' => $this->request->getPost('frenet_chave'),
            'frenet_senha' => $this->request->getPost('frenet_senha'),
            'frenet_token' => $this->request->getPost('frenet_token'),
            'email_notificacao' => $this->request->getPost('email_notificacao'),
            'email_notificacao_copia' => $this->request->getPost('email_notificacao_copia'),
            'email_notificacao_copia_oculta' => $this->request->getPost('email_notificacao_copia_oculta'),
            'email_usuario' => $this->request->getPost('email_usuario'),
            'email_senha' => $this->request->getPost('email_senha'),
            'email_smtp' => $this->request->getPost('email_smtp'),
            'email_smtp_porta' => $this->request->getPost('email_smtp_porta'),
            'email_tls' => $this->request->getPost('email_tls'),
            'texto_cadastro' => $this->request->getPost('texto_cadastro'),
            'texto_pedido' => $this->request->getPost('texto_pedido'),
            'site_id' => $this->request->getPost('site_id'),
            'created_usuario_id' => $this->request->getPost('created_usuario_id')
        ];
        $this->data['email_cabecalho_dim'] = '';
        $this->data['email_rodape_dim'] = '';
        foreach ($this->request->getFiles() as $k => $file) {
            if ($file->getName() != '') {
                $files[$k]['file'] = $file;
                $files[$k]['dim'] = \Config\Services::image()->withFile($file)->getWidth() . 'x' . \Config\Services::image()->withFile($file)->getHeight();
                $files[$k]['name'] = $file->getRandomName();
                $file->move($tmpPathFiles, $files[$k]['name']);
            }
        }
//        dd($files);
        if (isset($files['email_cabecalho'])) {
            $image = \Config\Services::image()->withFile($tmpPathFiles . '/' . $files['email_cabecalho']['name']);
            if (($image->getWidth() < 849 xor $image->getHeight() < 249)) {
                $this->data['email_cabecalho_dim'] = 'Imagem fora das dimenções aceitas1' . $files['email_cabecalho']['dim'];
                $vldt = true;
            } else {
                $image->fit(850, 250, 'center');
                if (!$image->save($pathFiles . '/' . $files['email_cabecalho']['name'])) {
                    $this->data['email_cabecalho_dim'] = 'Não foi possível salvar o arquivo!!';
                    $vldt = true;
                }
            }
            $values['email_cabecalho'] = $files['email_cabecalho']['name'];
        }
        if (isset($files['email_rodape'])) {
            $image = \Config\Services::image()->withFile($tmpPathFiles . '/' . $files['email_rodape']['name']);
            if (($image->getWidth() < 849 xor $image->getHeight() < 249)) {
                $this->data['email_rodape_dim'] = 'Imagem fora das dimenções aceitas1' . $files['email_rodape']['dim'];
                $vldt = true;
            } else {
                $image->fit(850, 250, 'center');
                if (!$image->save($pathFiles . '/' . $files['email_rodape']['name'])) {
                    $this->data['email_rodape_dim'] = 'Não foi possível salvar o arquivo!!';
                    $vldt = true;
                }
            }
            $values['email_rodape'] = $files['email_rodape']['name'];
        }
        if ($vldt) {
            if (isset($files['email_cabecalho'])) {
                if (is_file($tmpPathFiles . $files['email_cabecalho']['name'])) {
                    unlink($tmpPathFiles . $files['email_cabecalho']['name']);
                }
                if (is_file($pathFiles . $files['email_cabecalho']['name'])) {
                    unlink($pathFiles . $files['email_cabecalho']['name']);
                }
            }
            if (isset($files['email_rodape'])) {
                if (is_file($tmpPathFiles . $files['email_rodape']['name'])) {
                    unlink($tmpPathFiles . $files['email_rodape']['name']);
                }
                if (is_file($pathFiles . $files['email_rodape']['name'])) {
                    unlink($pathFiles . $files['email_rodape']['name']);
                }
            }
            return redirect()->to('admin/config/cadastro/' . $this->request->getPost('id'))->withInput();
//            echo view('Back/Configuracao/cadastro', $this->data);
//            exit();
        }

        $query = $this->configs->save($values);
        if (!$query) {

            return redirect()->back()->with('erro', 'Erro ao cadastrar');
        } else {
            return redirect()->to('admin/config')->with('sucesso', 'Cadastrado com sucesso');
        }
    }

}
