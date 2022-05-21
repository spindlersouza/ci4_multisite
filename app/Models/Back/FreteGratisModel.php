<?php

namespace App\Models\Back;

use CodeIgniter\Model;

class FreteGratisModel extends Model {

    protected $table = 'frete_gratis';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'valor', 'site_id'];

    
}
