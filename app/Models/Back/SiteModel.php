<?php

namespace App\Models\Back;

use CodeIgniter\Model;

class SiteModel extends Model {

    protected $table = 'site';
    protected $primaryKey = 'id';
    protected $allowedFieds = ['site', 'slug'];

}
