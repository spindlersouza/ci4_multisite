<?php

namespace App\Models\Back;

use CodeIgniter\Model;

class NivelAcessoModel extends Model {

    protected $table = 'nivel_acesso';
    protected $primaryKey = 'id';
    protected $allowedFieds = ['id', 'permissao'];

    
}
