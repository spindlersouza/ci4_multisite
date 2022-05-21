<?php

namespace App\Models\Back;

use CodeIgniter\Model;

class ProdutosFavoritosModel extends Model {

    protected $table = 'produtos_favoritos';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'site_id', 'cliente_id', 'produto_id'];
    protected $useAutoIncrement = true;

}
