<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use Config\Services;
use App\Models\Back\ConfiguracaoModel;
use App\Models\Back\SiteModel;
use App\Models\Back\ProdutosModel;
use App\Models\Back\ProdutosCategoriasModel;
use App\Models\Back\ProdutosSubcategoriasModel;
use App\Models\Back\ProdutosTiposAtributosModel;
use App\Models\Back\ProdutosValorAtributosModel;
use App\Models\Back\ProdutosAtributosModel;
use App\Models\Back\ProdutosGaleriaModel;

class Produtos extends BaseController {

    protected $configs;
    protected $sites;
    protected $produtos;
    protected $categoria;
    protected $subcategoria;
    protected $tipoatributos;
    protected $valoratributos;
    protected $atributos;
    protected $galeria;
    protected $data;
    protected $siteMarca;
    protected $dtArquivo;

    public function __construct() {
        helper("filesystem");
        $this->configs = new ConfiguracaoModel();
        $this->sites = new SiteModel();
        $this->produtos = new ProdutosModel();
        $this->dtArquivo = date('YmdHis');
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

    public function categorias() {
        if (!$this->checkToken($this->request->getHeaderLine('Token'))) {
            return json_encode(['erro' => 'true', 'msg' => 'Token invalido!!']);
        }

        $pstFull = json_decode($this->request->getBody());
        write_file("public/upload/produtos/importacoes/categorias" . date('Y-m-d H:i:s') . ".txt", $this->request->getBody());
        $ret = [
            'dataHoraServidor' => date('Y-m-d H:i:s'),
            'erros' => '',
            'registros' => []
        ];
        foreach ($pstFull as $pst) {
            if (!isset($pst->Id_Empresa)) {
                $ret['erros'][] = ['Id' => $pst->Id, 'CodSinc' => $pst->CodSinc, 'msg' => 'Id_Empresa nao informado!!'];
                continue;
            }

            $values = [
                'created_usuario_id' => '1',
                'site_id' => $this->siteMarca[$pst->Id_Empresa],
                'nome' => $pst->Nome,
                'slug' => mb_url_title($pst->Nome, '-', TRUE),
                'unique' => mb_url_title($pst->Nome . ' ' . $this->siteMarca[$pst->Id_Empresa], '-', TRUE),
                'cod_sinc' => $pst->CodSinc,
                'ativo' => $pst->Ativo == 'true' ? 1 : 0
            ];

            if ($pst->Id_Pai != '') {
                $this->categoria = new ProdutosCategoriasModel();
                $this->subcategoria = new ProdutosSubCategoriasModel();
                $rs = $this->subcategoria->select('id')->where('cod_sinc', $pst->CodSinc)->first();
                $rsCateg = $this->categoria->select('id')->where('cod_sinc', $pst->Id_Pai)->where('site_id', $pst->Id_Empresa)->first();
                $values['produtos_categorias_id'] = $this->categoria->select('id')->where('cod_sinc', $pst->Id_Pai)->where('site_id', $pst->Id_Empresa)->first()['id'];
                if (empty($rsCateg)) {
                    $ret['erros'] .= json_encode($this->subcategoria->errors()) . ', ';
                    $ret['erros'] .= json_encode(['Id' => $pst->Id, 'CodSinc' => $pst->CodSinc, 'msg' => 'Categoria pai nao cadastrada!!']) . ', ';
                    continue;
                }
                if (!empty($rs)) {
                    $values['id'] = $rs['id'];
                    $this->subcategoria->skipValidation(true);
                    unset($values['nome'], $values['slug'], $values['unique']);
                }

                if ($this->subcategoria->save($values)) {
                    $pst->Id = (empty($rs)) ? $this->subcategoria->insertID() : $rs['id'];
                    $ret['registros'][] = $pst;
                } else {
                    $ret['erros'] .= json_encode($this->subcategoria->errors()) . ', ';
                }
            } else {
                $this->categoria = new ProdutosCategoriasModel();
                $rs = $this->categoria->where('cod_sinc', $pst->CodSinc)->first();
                if (!empty($rs)) {
                    $values['id'] = $rs['id'];
                    $this->categoria->skipValidation(true);
                    unset($values['nome'], $values['slug'], $values['unique']);
                }
                if ($this->categoria->save($values)) {
                    $pst->Id = (empty($rs)) ? $this->categoria->insertID() : $rs['id'];
                    $ret['registros'][] = $pst;
                } else {
                    $ret['erros'] .= json_encode($this->categoria->errors()) . ', ';
                }
            }
        }
        write_file("public/upload/produtos/importacoes/categorias_retorno" . date('Y-m-d H:i:s') . ".txt", json_encode($ret));
        return json_encode($ret);
    }

    public function produto() {
        if (!$this->checkToken($this->request->getHeaderLine('Token'))) {
            return json_encode(['erro' => 'true', 'msg' => 'Token invalido!!']);
        }

        $ret = [];
        $pstFull = json_decode($this->request->getBody());
        write_file("public/upload/produtos/importacoes/produtos" . date('Y-m-d H:i:s') . ".txt", $this->request->getBody());
        $ret = [
            'dataHoraServidor' => date('Y-m-d H:i:s'),
            'erros' => '',
            'registros' => []
        ];
        foreach ($pstFull as $pst) {
            if (!isset($pst->Id_Marca)) {
                $ret['erros'][] = ['Id' => $pst->Id, 'CodSinc' => $pst->CodSinc, 'msg' => 'Id_Marca nao informado!!'];
                continue;
            }
            $subcateg = new ProdutosSubcategoriasModel();
            $this->subcategoria = $subcateg->select('produtos_categorias.id AS categoria_id,  produtos_categorias.slug AS categoria, produtos_subcategorias.id AS subcategoria_id, produtos_subcategorias.slug AS subcategoria')
                            ->join('produtos_categorias', 'produtos_categorias.id = produtos_subcategorias.produtos_categorias_id')
                            ->where('produtos_subcategorias.cod_sinc', $pst->Id_Hierarquia)->first();

            if (empty($this->subcategoria) || $this->subcategoria['categoria_id'] == '') {
                $ret['erros'][] = $pst;
                continue;
            }

            $values = [
                'site_id' => $this->siteMarca[$pst->Id_Empresa],
                'cod_sinc' => $pst->CodSinc,
                'created_usuario_id' => 1,
                'referencia' => $pst->Referencia,
                'nome' => $pst->Descricao,
                'descricao' => $pst->Descricao_Completa,
                'descricao_simplificada' => $pst->Descricao_Simplificada,
                'slug' => mb_url_title($pst->Descricao, '-', TRUE),
                'unique' => mb_url_title($this->subcategoria['categoria'] . ' ' . $this->subcategoria['subcategoria'] . ' ' . $pst->Descricao . ' ' . $this->siteMarca[$pst->Id_Empresa], '-', TRUE),
                'altura' => $pst->Altura,
                'largura' => $pst->Largura,
                'comprimento' => $pst->Comprimento,
                'peso' => $pst->Peso,
                'lancamento' => $pst->Lancamento == 'true' ? 1 : 0,
                'data_lancamento' => $pst->DataLancamento ?? null,
                'ativo' => $pst->Ativo == 'true' ? 1 : 0,
                'destaque' => $pst->Destaque ?? 0,
                'preco' => $pst->PrecoVarejo,
                'promo' => $pst->PrecoVarejoPromocional,
                'preco_rev' => $pst->PrecoAtacado,
                'promo_rev' => $pst->PrecoAtacadoPromocional,
                'desconto' => $pst->Desconto,
                'produtos_categorias_id' => $this->subcategoria['categoria_id'],
                'produtos_subcategorias_id' => $this->subcategoria['subcategoria_id'],
            ];
            if (is_file('public/upload/produtos/' . $pst->Video)) {
                $file = new \CodeIgniter\Files\File('public/upload/produtos/' . $pst->Video);
                if ($file->move('public/upload/produtos/video/', $pst->Video)) {
                    $values['video'] = $pst->Video;
                } else {
                    $ret['erros'] .= json_encode(['video' => $pst->Video . ' nao e possivel salvar']) . ', ';
                    continue;
                }
            }

            $rs = $this->produtos->select('id')->where('cod_sinc', $pst->CodSinc)->first();
            $this->produtos->skipValidation(false);
            if (!empty($rs)) {
                $values['id'] = $rs['id'];
                $this->produtos->skipValidation(true);
                unset($values['descricao'], $values['slug'], $values['unique']);
            }
            if ($this->produtos->save($values)) {
                $pst->Id = (empty($rs)) ? $this->produtos->insertID() : $rs['id'];
                $ret['registros'][] = $pst;
            } else {
                $ret['erros'] .= ($ret['erros'] != '' ? ',' : '') . 'erros:' . json_encode($this->produtos->errors());
            }
        }
        write_file("public/upload/produtos/importacoes/produtos_retorno" . $this->dtArquivo . ".txt", json_encode($ret));
        return json_encode($ret);
    }

    public function atributos() {
        if (!$this->checkToken($this->request->getHeaderLine('Token'))) {
            return json_encode(['erro' => 'true', 'msg' => 'Token invalido!!']);
        }

        $pstFull = json_decode($this->request->getBody());
        write_file("public/upload/produtos/importacoes/atributos" . $this->dtArquivo . ".txt", $this->request->getBody());
        $ret = [
            'dataHoraServidor' => date('Y-m-d H:i:s'),
            'erros' => [],
            'registros' => []
        ];
        foreach ($pstFull as $pst) {
            $this->produtos = new ProdutosModel();
            $produto = $this->produtos->where('id', $pst->Id_Produto)->first();
            if (empty($produto)) {
                $ret['erros'][] = ['CodSinc' => $pst->CodSinc, 'msg' => 'Produto nao informado!!'];
                continue;
            }

            $values = [
                'cod_sinc' => $pst->CodSinc,
                'created_usuario_id' => 1,
                'produtos_id' => $produto['id'],
                'peso' => $pst->Peso,
                'ativo' => $pst->Ativo == 'true' ? 1 : 0,
            ];
            $this->tipoatributos = new ProdutosTiposAtributosModel();
            $this->valoratributos = new ProdutosValorAtributosModel();
            $this->atributos = new ProdutosAtributosModel();
            foreach ($pst->Atributos as $k => $attr) {

                if ($k == 'IMAGEM_COR') {
                    continue;
                }
                $tipoid = '';
                $tipoid = $this->tipoatributos->where('tipo', $k)->first();
                if (empty($tipoid)) {
                    $valTipo = [
                        'cod_sinc' => $pst->CodSinc,
                        'tipo' => $k,
                        'created_usuario_id' => 1,
                    ];
                    $this->tipoatributos->save($valTipo);
                    $values['produtos_tipo_atributos_id'] = $this->tipoatributos->insertID();
                } else {
                    $values['produtos_tipo_atributos_id'] = $tipoid['id'];
                }

                $valorid = '';
                $valorid = $this->valoratributos->where('valor', $attr)->first();
                if (empty($valorid)) {
                    $valVal = [
                        'cod_sinc' => $pst->CodSinc,
                        'valor' => $attr,
                        'ordem' => '10',
                        'created_usuario_id' => 1,
                        'produtos_tipo_atributos_id' => $values['produtos_tipo_atributos_id'],
                    ];

                    if ($k == 'CORES') {
                        if ($pst->Atributos->IMAGEM_COR != '') {
                            if (is_file('public/upload/produtos/' . $pst->Atributos->IMAGEM_COR)) {
                                $file = new \CodeIgniter\Files\File('public/upload/produtos/' . $pst->Atributos->IMAGEM_COR);
                                if ($file->move('public/upload/produtos/cores/', $pst->Atributos->IMAGEM_COR)) {
                                    $valVal['imagem'] = $pst->Atributos->IMAGEM_COR;
                                }
                            }
                        }
                    }
                    $this->valoratributos->save($valVal);
                    $values['produtos_valor_atributos_id'] = $this->valoratributos->insertID();
                } else {
                    if ($k == 'CORES') {
                        if ($pst->Atributos->IMAGEM_COR != '') {
                            if (is_file('public/upload/produtos/' . $pst->Atributos->IMAGEM_COR)) {
                                $file = new \CodeIgniter\Files\File('public/upload/produtos/' . $pst->Atributos->IMAGEM_COR);
                                if ($file->move('public/upload/produtos/cores/', $pst->Atributos->IMAGEM_COR)) {
//                                    if ($valorid['imagem'] != '') {
//                                        if (is_file('public/upload/produtos/cores/' . $valorid['imagem'])) {
//                                            unlink('public/upload/produtos/cores/' . $valorid['imagem']);
//                                        }
//                                    }
                                    $valVal['id'] = $valorid['id'];
                                    $valVal['imagem'] = $pst->Atributos->IMAGEM_COR;
                                    $this->valoratributos->save($valVal);
                                }
                            }
                        }
                    }

                    $values['produtos_valor_atributos_id'] = $valorid['id'];
                }
                $attrib = $this->atributos
                        ->where('cod_sinc', $pst->CodSinc)
                        ->where('produtos_id', $values['produtos_id'])
                        ->where('produtos_tipo_atributos_id', $values['produtos_tipo_atributos_id'])
                        ->where('produtos_valor_atributos_id', $values['produtos_valor_atributos_id'])
                        ->first();
                if (!empty($attrib)) {
                    $values['id'] = $attrib['id'];
                }
                if ($values['produtos_tipo_atributos_id'] == 2) {
                    switch ($attr) {
                        case 'P': $valVal['ordem'] = '1';
                            break;
                        case 'M': $valVal['ordem'] = '2';
                            break;
                        case 'G': $valVal['ordem'] = '3';
                            break;
                        case 'GG': $valVal['ordem'] = '4';
                            break;
                        case 'XG': $valVal['ordem'] = '5';
                            break;
                    }
                }
                if ($this->atributos->save($values)) {
                    $ret['registros'][] = $pst;
                } else {
                    $ret['erros'][] = $this->atributos->errors();
                }
            }
        }
        write_file("public/upload/produtos/importacoes/atributos_retorno" . $this->dtArquivo . ".txt", json_encode($ret));
        return json_encode($ret);
    }

    public function imagens() {
        if (!$this->checkToken($this->request->getHeaderLine('Token'))) {
            return json_encode(['erro' => 'true', 'msg' => 'Token invalido!!']);
        }

        $pstFull = json_decode($this->request->getBody());
        write_file("public/upload/produtos/importacoes/imagens" . $this->dtArquivo . ".txt", $this->request->getBody());
        $ret = [
            'dataHoraServidor' => date('Y-m-d H:i:s'),
            'erros' => '',
            'registros' => []
        ];
        foreach ($pstFull as $pst) {
            $valGaleria = [];
            $file = new \CodeIgniter\Files\File('public/upload/produtos/' . $pst->Arquivo);
            if (!is_file($file)) {
                $ret['erros'] .= json_encode(['imagem' => $pst->Arquivo . ' nao existe']) . ', ';
                continue;
            }

            $arrCodSinc = explode(',', $pst->CodSinc);
            $prod = $this->produtos->select('id,imagem')->where('id', $pst->Id_Produto)->first();
            $this->galeria = new ProdutosGaleriaModel();
            $valGaleria = [
                'cod_sinc' => $pst->CodSinc,
                'produtos_id' => $prod['id'],
                'imagem' => $pst->Arquivo,
                'ordem' => $pst->Ordem,
                'cor' => $pst->Cor,
            ];

            $rsGal = $this->galeria->select('id, imagem')->where(['produtos_id' => $prod['id'], 'imagem' => $pst->Arquivo])->first();
            if (!empty($rsGal)) {
                $valGaleria['id'] = $rsGal['id'];
                if (is_file('public/upload/produtos/original/' . $rsGal['imagem'])) {
                    unlink('public/upload/produtos/original/' . $rsGal['imagem']);
                }
                if (is_file('public/upload/produtos/thumb_1200/' . $rsGal['imagem'])) {
                    unlink('public/upload/produtos/thumb_1200/' . $rsGal['imagem']);
                }
                if (is_file('public/upload/produtos/thumb_600/' . $rsGal['imagem'])) {
                    unlink('public/upload/produtos/thumb_600/' . $rsGal['imagem']);
                }
                if (is_file('public/upload/produtos/thumb_200/' . $rsGal['imagem'])) {
                    unlink('public/upload/produtos/thumb_200/' . $rsGal['imagem']);
                }
            }

            $image = \Config\Services::image()->withFile('public/upload/produtos/' . $pst->Arquivo);
            if (($image->getWidth() <= 1200 xor $image->getHeight() <= 1200)) {
                $ret['erros'] .= json_encode(['imagem' => $pst->Arquivo . ' fora do tamanho: ' . $image->getWidth() . 'x' . $image->getHeight()]) . ', ';
                continue;
            }

            if (!$image->save('public/upload/produtos/original/' . $pst->Arquivo)) {
                $ret['erros'] .= json_encode(['Arquivo' => $pst->Arquivo, 'CodSinc' => $pst->CodSinc, 'msg' => 'Nao foi possivel mover o arquivo!!']) . ', ';
                continue;
            }

            if (!$image->withFile('public/upload/produtos/' . $pst->Arquivo)->fit(1200, 1200, 'center')->save('public/upload/produtos/thumb_1200/' . $pst->Arquivo)) {
                $ret['erros'] .= json_encode(['Arquivo' => $pst->Arquivo, 'CodSinc' => $pst->CodSinc, 'msg' => 'Nao foi possivel redimensionar(1200) o arquivo!!']) . ', ';
                continue;
            }
            if (!$image->withFile('public/upload/produtos/' . $pst->Arquivo)->fit(600, 600, 'center')->save('public/upload/produtos/thumb_600/' . $pst->Arquivo)) {
                $ret['erros'] .= json_encode(['Arquivo' => $pst->Arquivo, 'CodSinc' => $pst->CodSinc, 'msg' => 'Nao foi possivel redimensionar(600) o arquivo!!']) . ', ';
                continue;
            }
            if (!$image->withFile('public/upload/produtos/' . $pst->Arquivo)->fit(200, 200, 'center')->save('public/upload/produtos/thumb_200/' . $pst->Arquivo)) {
                $ret['erros'] .= json_encode(['Arquivo' => $pst->Arquivo, 'CodSinc' => $pst->CodSinc, 'msg' => 'Nao foi possivel redimensionar(200) o arquivo!!']) . ', ';
                continue;
            }


            if (!$this->galeria->save($valGaleria)) {
                $ret['erros'] .= json_encode(['Arquivo' => $pst->Arquivo, 'CodSinc' => $pst->CodSinc, 'msg' => 'Nao foi possivel salvar na galeria!!']) . ', ';
                continue;
            }

            if ($pst->Principal == 'true') {
                $rsGaleria = $this->galeria->select('id')->where('imagem', $prod['imagem'])->where('produtos_id', $prod['id'])->first();
                if (!$this->galeria->delete(['id', $rsGaleria['id']])) {
                    $ret['erros'] .= json_encode(['Arquivo' => $pst->Arquivo, 'CodSinc' => $pst->CodSinc, 'msg' => 'Nao foi possivel exckuir imagem principal na galeria!!']) . ', ';
                    continue;
                }

                if ($prod['imagem'] != '' && is_file('public/upload/produtos/original/' . $prod['imagem'])) {
                    unlink('public/upload/produtos/original/' . $prod['imagem']);
                    unlink('public/upload/produtos/thumb_1200/' . $prod['imagem']);
                    unlink('public/upload/produtos/thumb_600/' . $prod['imagem']);
                    unlink('public/upload/produtos/thumb_200/' . $prod['imagem']);
                }
                $valProd = [
                    'id' => $prod['id'],
                    'imagem' => $pst->Arquivo,
                ];
                $this->produtos->skipValidation(true);
                $this->produtos->save($valProd);
            }

            unlink('public/upload/produtos/' . $pst->Arquivo);
            $ret['registros'][] = $pst;
        }
        write_file("public/upload/produtos/importacoes/imagens_retorno" . $this->dtArquivo . ".txt", json_encode($ret));
        return json_encode($ret);
    }

    public function deleteImagens() {
        if (!$this->checkToken($this->request->getHeaderLine('Token'))) {
            return json_encode(['erro' => 'true', 'msg' => 'Token invalido!!']);
        }
        $pst = json_decode($this->request->getBody());
        write_file("public/upload/produtos/importacoes/deleteImagens" . $this->dtArquivo . ".txt", $this->request->getBody());
        $this->galeria = new ProdutosGaleriaModel();
        $rsGaleria = $this->galeria->where(['cod_sinc' => $pst->CodSinc, 'imagem' => $pst->Arquivo])->first();
        if (empty($rsGaleria)) {
            write_file("public/upload/produtos/importacoes/deleteImagens_retorno" . $this->dtArquivo . ".txt", json_encode(['erro' => 'Imagem nao encontrada!!']));
            return json_encode(['erro' => 'Imagem nao encontrada!!']);
        }
        if (!$this->galeria->delete(['id', $rsGaleria['id']])) {
            write_file("public/upload/produtos/importacoes/deleteImagens_retorno" . $this->dtArquivo . ".txt", json_encode(['erro' => 'Nao foi possivel excluir!']));
            return json_encode(['erro' => 'Nao foi possivel excluir!']);
        }
        unlink('public/upload/produtos/original/' . $pst->Arquivo);
        unlink('public/upload/produtos/thumb_1200/' . $pst->Arquivo);
        unlink('public/upload/produtos/thumb_600/' . $pst->Arquivo);
        unlink('public/upload/produtos/thumb_200/' . $pst->Arquivo);

        write_file("public/upload/produtos/importacoes/deleteImagens_retorno" . $this->dtArquivo . ".txt", json_encode(['removido' => 'true']));
        return json_encode(['removido' => 'true']);
    }

}
