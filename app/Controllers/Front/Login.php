<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;
use App\Models\Back\SiteModel;
use App\Models\Back\ConfiguracaoModel;
use App\Models\Back\EstadoModel;
use App\Models\Back\CidadeModel;
use App\Models\Back\PaginasModel;
use App\Models\Front\ClientesModel;
use App\Models\Back\ProdutosFavoritosModel;
use App\Libraries\Hash;

class Login extends BaseController {

    protected $cliente;
    protected $configs;
    protected $estados;
    protected $cidades;
    protected $sites;
    protected $paginas;
    protected $data;

    public function __construct() {
        helper(['url', 'form']);
        $this->cliente = new ClientesModel();
        $this->configs = new ConfiguracaoModel();
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
            'estados' => $this->estados->get()->getResult('array'),
        ];
    }

    public function index() {
        if (session()->has('cliente_id')) {
            return redirect()->to('/minha-conta');
        }
        $this->data['menus'] = $this->menuCategorias;
        $this->data['submenus'] = $this->menuSubCategorias;
        $this->data['carrinhoTopo'] = $this->carrinhoTopo;
        $this->data['carrinhoItensTopo'] = $this->carrinhoItensTopo;
        return view('Front/Login/index', $this->data);
    }

    public function login() {
        $validation = $this->validate([
            'email' => [
                'rules' => 'required|is_not_unique[clientes.email]',
                'errors' => [
                    'required' => 'Campo obrigátório',
                    'is_not_unique' => 'Usuário não cadastrado'
                ],
            ],
            'senha' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Campo obrigátório',
                ],
            ],
        ]);
        if (!$validation) {
            $errors = array(
                'error' => $this->validator->getErrors()
            );
            session()->setFlashdata($errors);

            return redirect()->back()->withInput();
        } else {
            $login = $this->request->getPost('email');
            $password = $this->request->getPost('senha');

            $cliente = $this->cliente->where(['email' => $login])->first();
            $check = Hash::check($password, $cliente['senha']);

            if (!$check) {
                session()->setFlashdata('erroLogin', 'Senha incorreta');
                return redirect()->to('/login')->withInput();
            } else {
                $primeiro = explode(' ', $cliente['nome']);
                session()->set('cliente_id', $cliente['id']);
                session()->set('cliente_primiero_nome', $primeiro[0]);
                session()->set('cliente_nome', $cliente['nome']);
                session()->set('cliente_email', $cliente['email']);
                session()->set('cliente_tipo', $cliente['tipo_id']);

                $produtos = [];
                if (isset($_COOKIE['favoritos'])) {
                    $cc = json_decode($_COOKIE['favoritos'], true);
                    foreach ($cc['produtos'] as $fav) {
                        $produtos[] = $fav;
                    }
                }
                $this->favoritos = new ProdutosFavoritosModel();
                foreach ($this->favoritos->where(['cliente_id' => session('cliente_id')])->get()->getResult('array') as $k => $fav) {
                    $this->favoritos->delete(['id' => $fav['id']]);
                    $produtos[] = $fav['produto_id'];
                }
                $prods = array_unique($produtos);
                foreach ($prods as $fav) {
                    $this->favoritos->save(['cliente_id' => session('cliente_id'), 'site_id' => SITEENABLED, 'produto_id' => $fav]);
                }
                $favoritos = json_encode(['cliente_id' => session('cliente_id'), 'site_id' => SITEENABLED, 'produtos' => $prods]);
                setcookie("favoritos", $favoritos, time() + 3600 * 24 * 7, "/");

                if (session('origem_link')) {
                    $link = session('origem_link');
                    session()->remove('origem_link');
                    return redirect()->to($link)->withInput();
                } else {
                    return redirect()->to('/minha-conta')->withInput();
                }
            }
        }
    }

    public function logout() {
        if (session()->has('cliente_id')) {
            session()->remove('cliente_id');
            session()->remove('cliente_primeiro_nome');
            session()->remove('cliente_nome');
            session()->remove('cliente_email');
            session()->remove('cliente_tipo');
        }
        return redirect()->to('/');
    }

    public function cadastro($id = null) {
        if (session()->has('cliente_id')) {
            $this->data['cliente'] = $this->cliente->where('id', session('cliente_id'))->first();
        }

        echo view('Front/MinhaConta/index', $this->data);
    }

    public function save() {
        $ret['error'] = false;
        $ret['erros'] = [];
        $captcha = $this->request->getPost('g-recaptcha-response');
        if ($captcha == '') {
            session()->setFlashdata('captcha', 'Captcha Inválido');
            $ret['error'] = true;
            $ret['erros'][] = ['captcha' => 'Captcha Inválido'];
        } else {
            $secret = '6Lcco1MdAAAAAIaVregaB1PlP88kXRzEbvSNWbgl';
            $response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']));
            if ($response->success === false) {
                $ret['error'] = true;
                $ret['erros'][] = ['captcha' => 'Captcha Inválido'];
            }
        }
        if ($this->request->getPost('csenha') != $this->request->getPost('senha')) {
            $ret['error'] = true;
            $ret['erros'][] = ['senhas' => 'Senhas não conferem'];
        }

        $values = [
            'tipo_id' => 1,
            'nome' => $this->request->getPost('nome'),
            'cpf' => $this->request->getPost('cpf'),
            'data_nascimento' => implode('-', array_reverse(explode('/', $this->request->getPost('data_nascimento')))),
            'telefone' => $this->request->getPost('telefone'),
            'celular' => $this->request->getPost('celular'),
            'cep' => str_replace('-', '', $this->request->getPost('cep')),
            'estado_id' => $this->request->getPost('estado_id'),
            'cidade_id' => $this->request->getPost('cidade_id'),
            'endereco' => $this->request->getPost('endereco'),
            'numero' => $this->request->getPost('numero'),
            'complemento' => $this->request->getPost('complemento'),
            'bairro' => $this->request->getPost('bairro'),
            'email' => $this->request->getPost('email'),
            'senha' => Hash::make($this->request->getPost('senha')),
        ];

        if (session()->has('cliente_id')) {
            $values['id'] = session('cliente_id');
        }
        $ret['registro'] = $values;

        if (!$this->cliente->save($values)) {
            $erros = json_encode($this->cliente->errors());
            $ret['error'] = true;
            $ret['erros'][] = $erros;
        } else {
            session()->set('cliente_id', $this->cliente->insertID());
            session()->set('cliente_nome', $values['nome']);
            session()->set('cliente_email', $values['email']);
            session()->set('cliente_tipo', $values['tipo_id']);
        }
        $config = $this->configs->where('site_id', SITEENABLED)->first();
        $htmlMsg = ''
                . ' <section class="border border-gray my-5">'
                . '     <div style="max-width: 850px; margin: 0 10%;">'
                . '         <img src="' . base_url('public/upload/configs/' . $config['email_cabecalho']) . '" style="width: 100%;">'
                . '         <br><br>'
                . '         <span>' . date('d/m/Y - H:i') . '</span>'
                . '         <br><br>'
                . '         <h3>Cadastro Realizado com sucesso!</h3>'
                . '         <br><br><br>'
                . '         <p>'
                . '             <b>Prezado(a) Cliente ' . $values['nome'] . ',</b><br> '
                . '             É uma grande satisfação ter você como nosso cliente. <br><br>'
                . '             A PARTIR DE AGORA, UTILIZE SEU E-MAIL E SUA SENHA para acessar seu PAINEL DE CONTROLE, acompanhar os seus PEDIDOS ou gerenciar o seu CADASTRO.<br><br>'
                . '         </p>'
                . '         <br><br>'
                . '         <p> Equipe :: Grupo Instinto Íntimo<br>Copyright © 2022 - TODOS OS DIREITOS RESERVADOS</p><br>'
                . '         <img src="' . base_url('public/upload/configs/' . $config['email_rodape']) . '" alt="" style="width: 100%;">'
                . '     </div>'
                . ' </section>';

        $configs['protocol'] = 'smtp';
        $configs['SMTPHost'] = $config['email_smtp'];
        $configs['SMTPPort'] = $config['email_smtp_porta'];
        $configs['smtp_timeout'] = '7';
        $configs['SMTPUser'] = $config['email_usuario'];
        $configs['SMTPPass'] = $config['email_senha'];
        $configs['charset'] = 'utf-8';
        $configs['newline'] = "\r\n";
        $configs['mailtype'] = 'html';
        $configs['validation'] = FALSE;
        $email = new \CodeIgniter\Email\Email($configs);
        $email->setFrom($config['email_usuario'], 'Grupo Instinto Intimo');
        $email->setTo($values['email']);
        if ($configs['email_notificacao_copia_oculta'] != '') {
            $email->setCC($configs['email_notificacao_copia']);
        }
        if ($configs['email_notificacao_copia_oculta'] != '') {
            $email->setBCC($configs['email_notificacao_copia_oculta']);
        }
        $email->setSubject('Novo Cadastro');
        $email->setMessage($htmlMsg);
        $email->mailType = 'html';
        if (!$email->send()) {
            
        }
        return json_encode($ret);
    }

    public function upconta() {
        $ret['error'] = false;
        $ret['erros'] = [];
        $captcha = $this->request->getPost('g-recaptcha-response');
        if ($captcha == '') {
            session()->setFlashdata('captcha', 'Captcha Inválido');
            $ret['error'] = true;
            $ret['erros'][] = ['captcha' => 'Captcha Inválido'];
        } else {
            $secret = '6Lcco1MdAAAAAIaVregaB1PlP88kXRzEbvSNWbgl';
            $response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']));
            if ($response->success === false) {
                $ret['error'] = true;
                $ret['erros'][] = ['captcha' => 'Captcha Inválido'];
            }
        }
        if ($this->request->getPost('csenha') != $this->request->getPost('senha')) {
            $ret['error'] = true;
            $ret['erros'][] = ['senhas' => 'Senhas não conferem'];
        }

        $values = [
            'id' => $this->request->getPost('id'),
            'tipo_id' => 1,
            'nome' => $this->request->getPost('nome'),
            'cpf' => $this->request->getPost('cpf'),
            'data_nascimento' => implode('-', array_reverse(explode('/', $this->request->getPost('data_nascimento')))),
            'telefone' => $this->request->getPost('telefone'),
            'celular' => $this->request->getPost('celular'),
            'cep' => str_replace('-', '', $this->request->getPost('cep')),
            'estado_id' => $this->request->getPost('estado_id'),
            'cidade_id' => $this->request->getPost('cidade_id'),
            'endereco' => $this->request->getPost('endereco'),
            'numero' => $this->request->getPost('numero'),
            'complemento' => $this->request->getPost('complemento'),
            'bairro' => $this->request->getPost('bairro'),
        ];

        $this->cliente->skipValidation(true);
        $ret['registro'] = $values;
        if (!$this->cliente->save($values)) {
            $erros = json_encode($this->cliente->errors());
            $ret['error'] = true;
            $ret['erros'][] = $erros;
        }
        return json_encode($ret);
    }

    public function esqueceusenha() {

        $email = $this->request->getPost('email');
        $rs = $this->cliente->where(['email' => $email])->first();
        if (empty($rs)) {
            return false;
        }
        $check = Hash::check($password, $usuario['senha']);
        $hs = Hash::make($email);
    }

}
