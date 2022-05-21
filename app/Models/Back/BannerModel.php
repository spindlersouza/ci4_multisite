<?php

namespace App\Models\Back;

use CodeIgniter\Model;

class BannerModel extends Model {

    protected $table = 'banner';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id',
        'ordem', 'nome', 'link',
        'banner', 'banner_mobile',
        'texto', 'data_inicio', 'data_fim', 'ativo', 'tipo_id',
        'site_id', 'created_usuario_jd', 'deleted_usuario_id',
        'created_at', 'updated_at', 'deleted_at'];
    protected $useAutoIncrement = true;
    protected $useSoftDeletes = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    public function getBannerBySiteId($id, $tipo, $limit = null) {

        if ($limit == 1) {
            return $this->where('site_id', $id)->where('tipo_id', $tipo)->where('ativo', 1)->first();
        } else if ($limit != null) {
            return $this->where('site_id', $id)->where('tipo_id', $tipo)->where('ativo', 1)->limit($limit)->get()->getResult('array');
        } else {
            return $this->where('site_id', $id)->where('tipo_id', $tipo)->where('ativo', 1)->get()->getResult('array');
        }
    }

}
