<?php

namespace App\Controllers\Back;

use App\Controllers\BaseController;
use App\Models\Back\AuthModel;
use App\Libraries\Hash;

class Auth extends BaseController {

    protected $auth;

    public function __construct() {
        helper(['url', 'form']);
        $this->auth = new AuthModel();
    }

    public function index() {
        echo view('Back/_head');
        echo view('Back/Auth/login');
        echo view('Back/_footer');
    }

    public function list() {
        $data = ['usuarios' => $this->auth->get()->getResult('array')];
        echo view('Back/Auth/list', $data);
    }

    public function login() {
        $validation = $this->validate([
            'login' => [
                'rules' => 'required|is_not_unique[usuarios.login]',
                'errors' => [
                    'required' => 'Campo obrigátório',
                    'is_not_unique' => 'Usuário não cadastrado'
                ],
            ],
            'password' => [
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
            $login = $this->request->getPost('login');
            $password = $this->request->getPost('password');

            $usuario = $this->auth->where(['login' => $login])->first();
            $check = Hash::check($password, $usuario['senha']);

            if (!$check) {
                session()->setFlashdata('erroLogin', 'Senha incorreta');
                return redirect()->back()->withInput();
            } else {
                session()->set('admin_usuario_id', $usuario['id']);
                session()->set('admin_usuario_nome', $usuario['nome']);
                return redirect()->to('/admin/dashboard');
            }
        }
    }

    public function logout() {
        if (session()->has('admin_usuario_id')) {
            session()->remove('admin_usuario_id');
            return redirect()->to('/admin/login');
        }
        return redirect()->to('/admin/login');
    }

    public function cadastro($id = null) {
        if ($id) {
            $data['usuario'] = $this->auth->where('id', $id)->first();
        }
        $data['tipo'] = 'Cadastrar';
        echo view('Back/Auth/cadastro', $data);
    }

    public function save() {
        $rules = [
            'nome' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Campo obrigatório',
                ],
            ],
//            'email' => [
//                'rules' => 'required|valid_email|is_unique[usuarios.email]',
//                'errors' => [
//                    'required' => 'Campo obrigátório',
//                    'valid_email' => 'Email inválido',
//                    'is_unique' => 'Email já está em uso'
//                ],
//            ],
            'login' => [
                'rules' => 'required|is_unique[usuarios.login]',
                'errors' => [
                    'required' => 'Campo obrigátório',
                    'is_unique' => 'Login já está em uso'
                ],
            ],
            'password' => [
                'rules' => 'required|min_length[6]|max_length[10]',
                'errors' => [
                    'required' => 'Campo obrigátório',
                    'min_length' => 'Senha deve ter entre 5 e 10 caracteres',
                    'mix_length' => 'Senha deve ter entre 5 e 10 caracteres',
                ],
            ],
            'cpassword' => [
                'rules' => 'required|min_length[6]|max_length[10]|matches[password]',
                'errors' => [
                    'required' => 'Campo obrigátório',
                    'min_length' => 'Senha deve ter entre 5 e 10 caracteres',
                    'mix_length' => 'Senha deve ter entre 5 e 10 caracteres',
                    'matches' => 'Senhas não conferem',
                ],
            ],
        ];

        $validation = $this->validate($rules);

        if (!$validation) {
            $data = ['tipo' => 'validando', 'validation' => $this->validator];
            echo view('Back/_head');
            echo view('Back/Auth/cadastro', $data);
            echo view('Back/_footer');
        } else {

            $nome = $this->request->getPost('nome');
            $email = $this->request->getPost('email');
            $login = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            $usuarioId = session('admin_usuario_id') ?? '1';

            $values = [
                'nome' => $nome,
                'email' => $email,
                'login' => $login,
                'senha' => Hash::make($password),
                'usuario_id' => $usuarioId,
            ];

            $query = $this->auth->save($values);
            if (!$query) {
                return redirect()->back()->with('erro', 'Erro ao cadastrar');
            } else {
                return redirect()->to('admin/auth/list')->with('sucesso', 'Cadastrado com sucesso');
            }
        }
    }

}
