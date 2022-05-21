<?php

namespace App\Models\Back;

use CodeIgniter\Model;

class EstadoModel extends Model {

    protected $table = 'estado';
    protected $primaryKey = 'id';
    protected $allowedFieds = ['nome', 'uf'];

}
