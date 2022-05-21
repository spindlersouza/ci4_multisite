<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthCheckFilter implements FilterInterface {

    public function before(RequestInterface $request, $arguments = null) {

        if (!session()->has('usuario_id')) {
            return redirect()->to('/usuario/login')->with('error', 'Você precisa estar logado para acessar!!');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
        // Do something here
    }

}
