<?php

namespace App\Models\Back;

use CodeIgniter\Model;

class ConfiguracaoModel extends Model {

    protected $table = 'configuracao';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id', 
        'cep_remetente', 'correios_usuario', 'correios_senha', 
        'pagseguro_ambiente', 'pagseguro_email', 'pagseguro_token', 
        'frenet_chave', 'frenet_senha', 'frenet_token', 
        'email_notificacao', 'email_notificacao_copia', 'email_notificacao_copia_oculta', 
        'email_usuario', 'email_senha', 'email_smtp', 'email_smtp_porta', 'email_tls', 
        'email_cabecalho', 'email_rodape', 
        'texto_cadastro', 'texto_pedido', 
        'site_id', 'created_usuario_id', 'created_at', 'updated_at'];

    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    

    
}
