<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminAuthCheckedFilter implements FilterInterface {

    public function before(RequestInterface $request, $arguments = null) {

        if (session()->has('admin_usuario_id')) {
//            die('LOGADO');
            return redirect()->to('admin/dashboard');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
        // Do something here
    }

}
