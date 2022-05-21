<?php

namespace App\Models\Back;

use CodeIgniter\Model;

class ProdutosModel extends Model {

    protected $table = 'produtos';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id', 'cod_sinc', 'referencia', 'nome', 'descricao', 'imagem', 'video', 'slug', 'unique',
        'altura', 'largura', 'comprimento', 'diametro', 'peso',
        'preco', 'promo', 'preco_rev', 'promo_rev',
        'avaliacao', 'ativo', 'destaque', 'lancamento', 'data_lancamento',
        'produtos_subcategorias_id', 'produtos_categorias_id', 'site_id',
        'created_usuario_id', 'deleted_usuario_id', 'created_at', 'updated_at', 'deleted_at'
    ];
    protected $useAutoIncrement = true;
    protected $useSoftDeletes = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    protected $skipValidation = false;
    protected $validationRules = [
        'unique' => 'required|is_unique[produtos.unique]',
        'nome' => 'required',
        'slug' => 'required',
        'cod_sinc' => 'required',
        'site_id' => 'required',
        'ativo' => 'required',
        'altura' => 'required',
        'largura' => 'required',
        'comprimento' => 'required',
    ];
    protected $validationMessages = [
        'unique' => ['required' => 'Campo obrigatorio', 'is_unique' => 'Produto Duplicado (Categoria-Subcategoria-Nome-Site_id)'],
        'nome' => ['required' => 'Campo obrigatorio'],
        'slug' => ['required' => 'Campo obrigatorio'],
        'cod_sinc' => ['required' => 'Campo obrigatorio'],
        'site_id' => ['required' => 'Campo obrigatorio'],
        'ativo' => ['required' => 'Campo obrigatorio'],
        'altura' => ['required' => 'Campo obrigatorio'],
        'largura' => ['required' => 'Campo obrigatorio'],
        'comprimento' => ['required' => 'Campo obrigatorio'],
    ];

}
