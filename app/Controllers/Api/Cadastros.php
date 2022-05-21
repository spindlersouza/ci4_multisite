<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use Config\Services;
use App\Models\Back\ConfiguracaoModel;
use App\Models\Back\SiteModel;
use App\Models\Front\ClientesModel;
use App\Libraries\Hash;

class Cadastros extends BaseController {

    protected $configs;
    protected $sites;
    protected $data;
    protected $siteMarca;
    protected $cadastro;

    public function __construct() {
        $this->configs = new ConfiguracaoModel();
        $this->sites = new SiteModel();
        $this->cadastro = New ClientesModel();
        $this->siteMarca = [
            '1' => 1,
            '2' => 2,
            '3' => 3,
            'nuez' => 1,
            'vibrance' => 2,
            'milan' => 3,
        ];
        $this->data = [
            'slug' => SITESLUG,
            'site_id' => SITEENABLED,
            'configs' => $this->configs->where('site_id', SITEENABLED)->first(),
        ];
    }

    public function checkToken($token) {
        return (trim(str_replace('Token:', '', $token)) == date('YdHm'));
    }

    public function cadVendedores() {
        if (!$this->checkToken($this->request->getHeaderLine('Token'))) {
            return json_encode(['erro' => 'true', 'msg' => 'Token invalido!!']);
        }

        $pstFull = json_decode($this->request->getBody());
        $ret = [
            'dataHoraServidor' => date('Y-m-d H:i:s'),
            'erros' => '',
            'registros' => []
        ];
        foreach ($pstFull as $pst) {
            $values = [
                'tipo_id' => '2',
                'email' => $pst->Email,
                'senha' => Hash::make($pst->Senha),
                'nome' => $pst->Nome,
                'cod_sinc' => $pst->CodSinc,
                'ativo' => $pst->Ativo == 'true' ? 1 : 0
            ];
            $rs = $this->cadastro->select('id')->where('cod_sinc', $pst->CodSinc)->first();
            if (!empty($rs)) {
                $values['id'] = $rs['id'];
            }
            $this->cadastro->skipValidation(true);
            if ($this->cadastro->save($values)) {
                $pst->Id = (empty($rs)) ? $this->cadastro->insertID() : $rs['id'];
                $ret['registros'][] = $pst;
            } else {
                $ret['erros'] .= json_encode($this->cadastro->errors()) . ', ';
            }
        }
        return json_encode($ret);
    }

}
