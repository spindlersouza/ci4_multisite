<?php

namespace App\Controllers\Back;

use App\Controllers\BaseController;
use App\Models\Back\InfoSiteModel;
use App\Models\Back\AuthModel;

class Dashboard extends BaseController {

    public function index() {

        $info = new InfoSiteModel();
        $infos = $info->first();

        $user = new AuthModel();
        $usuario = $user->where('id', session('admin_usuario_id'))->first();
        $data = [
            'info' => $infos,
            'usuario' => $usuario
        ];

        return view('Back/Dashboard/index', $data);
    }

}
