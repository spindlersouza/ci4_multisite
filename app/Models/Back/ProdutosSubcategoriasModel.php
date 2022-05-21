<?php

namespace App\Models\Back;

use CodeIgniter\Model;

class ProdutosSubcategoriasModel extends Model {

    protected $table = 'produtos_subcategorias';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'cod_sinc', 'nome', 'imagem', 'slug', 'unique', 'ativo', 'produtos_categorias_id', 'site_id', 'created_usuario_id', 'deleted_usuario_id', 'created_at', 'updated_at', 'deleted_at'];
    protected $useAutoIncrement = true;
    protected $useSoftDeletes = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'nome' => 'required',
        'slug' => 'required',
        'cod_sinc' => 'required',
        'site_id' => 'required',
        'unique' => 'required|is_unique[produtos_subcategorias.unique]',
    ];
    protected $validationMessages = [
        'unique' => ['required' => 'Campo obrigatorio', 'is_unique' => 'Categoria duplicada (Nome-Site_id)'],
        'nome' => ['required' => 'Campo obrigatorio'],
        'slug' => ['required' => 'Campo obrigatorio'],
        'cod_sinc' => ['required' => 'Campo obrigatorio'],
        'site_id' => ['required' => 'Campo obrigatorio'],
    ];

}
