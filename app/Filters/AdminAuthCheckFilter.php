<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminAuthCheckFilter implements FilterInterface {

    public function before(RequestInterface $request, $arguments = null) {

        if (!session()->has('admin_usuario_id')) {
            session()->setFlashdata('erro', 'Você precisa estar logado para acessar!!');
            return redirect()->to('admin/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
        // Do something here
    }

}
