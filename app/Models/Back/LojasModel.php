<?php

namespace App\Models\Back;

use CodeIgniter\Model;

class LojasModel extends Model {

    protected $table = 'lojas';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'estado_id', 'cidade_id', 'localizacao', 'telefone', 'whatsapp', 'site_id', 'created_usuario_id', 'deleted_usuario_id', 'created_at', 'updated_at', 'deleted_at'];
    protected $useAutoIncrement = true;
    protected $useSoftDeletes = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

}
