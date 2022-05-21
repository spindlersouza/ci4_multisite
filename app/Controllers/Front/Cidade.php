<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;
use App\Models\Back\EstadoModel;
use App\Models\Back\CidadeModel;

class Cidade extends BaseController {

    public function listCidades($estado_id) {
        $cits = new CidadeModel;
        echo  $cits->listCidades($estado_id);
    }

}
