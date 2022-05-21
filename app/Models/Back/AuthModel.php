<?php

namespace App\Models\Back;

use CodeIgniter\Model;

class AuthModel extends Model {

    protected $table = 'usuarios';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nome', 'email', 'senha', 'usuario_id', 'site_id'];

}
