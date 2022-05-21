<?php

namespace App\Models\Back;

use CodeIgniter\Model;

class DuvidasModel extends Model {

    protected $table = 'duvidas';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'duvida', 'resposta', 'site_id', 'created_usuario_id', 'deleted_usuario_id', 'created_at', 'updated_ar', 'deleted_at'];

    protected $useAutoIncrement = true;
    protected $useSoftDeletes = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
   
    

    
}
