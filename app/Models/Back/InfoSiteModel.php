<?php

namespace App\Models\Back;

use CodeIgniter\Model;

class InfoSiteModel extends Model {

    protected $table = 'informacao_site';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id', 'nome', 'logo', 'banner_link', 'mapa', 'site_id', 
        'facebook', 'instagram', 'twitter', 'linkedin', 'youtube', 
        'email', 'telefone', 'whatsapp', 
        'cep', 'estado_id', 'cidade_id', 'bairro', 'endereco', 'numero', 'complemento', 
        'created_at', 'updated_at'
    ];

}
