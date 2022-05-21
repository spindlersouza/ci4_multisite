<?php

namespace App\Models\Back;

use CodeIgniter\Model;

class PaginasModel extends Model {

    protected $table = 'paginas';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'site_id', 'nome', 'slug', 'label', 'banner', 'banner_ativo', 'texto', 'created_usuario_id', 'created_at', 'updated_at'];

}
