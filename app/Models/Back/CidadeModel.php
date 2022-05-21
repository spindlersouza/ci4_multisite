<?php

namespace App\Models\Back;

use CodeIgniter\Model;

class CidadeModel extends Model {

    protected $table = 'cidade';
    protected $primaryKey = 'id';
    protected $allowedFieds = ['nome', 'estado_id'];

    public function listCidades($uf) {
        return json_encode($this->where('estado_id', $uf)->get()->getResult('array'));
    }
    
}
