<?php

namespace App\Models\Back;

use CodeIgniter\Model;

class NewsModel extends Model {

    protected $table = 'newsletter';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nome', 'email', 'site_id'];

    
}
