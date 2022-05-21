<?php

namespace App\Models\Back;

use CodeIgniter\Model;

class TopicosModel extends Model {

    protected $table = 'topicos';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'icone', 'titulo', 'texto', 'link', 'site_id',];
    protected $useAutoIncrement = true;

}
