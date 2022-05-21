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
use App\Models\Front\ClientesModel;
use App\Models\Front\CarrinhoModel;
use App\Models\Front\CarrinhoItensModel;

class Pedidos extends BaseController {

    protected $sites;
    protected $clientes;
    protected $carrinho;
    protected $carrinhoItens;
    protected $produtos;
    protected $produtosCategorias;
    protected $produtosSubCategorias;
    protected $produtosTiposAtributos;
    protected $produtosValorAtributos;
    protected $produtosAtributos;

    public function __construct() {
        helper("filesystem");
        $this->configs = new ConfiguracaoModel();
        $this->sites = new SiteModel();
        $this->produtos = new ProdutosModel();
        $this->produtosAtributos = new ProdutosModel();
        $this->dtArquivo = date('YmdHis');
        $this->carrinho = new CarrinhoModel();
        $this->carrinhoItens = new CarrinhoItensModel();
        $this->clientes = new ClientesModel();
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

    public function exportaPedidos() {
//        if (!$this->checkToken($this->request->getHeaderLine('Token'))) {
//            return json_encode(['erro' => 'true', 'msg' => 'Token invalido!!']);
//        }
//        $dt = $this->request->getHeaderLine('Data');
        $pedido = [];
        $carrinhos = $this->carrinho->select('carrinho.*, cidade.nome AS cidade, estado.uf AS UF')
                        ->join('cidade', 'cidade.id = carrinho.cidade_id', 'LEFT')
                        ->join('estado', 'estado.id = carrinho.estado_id', 'LEFT')
                        ->where('data_compra IS NOT NULL')->get()->getResult('array');
        echo '<pre>';
        foreach ($carrinhos as $carrinho) {
            $cliente = $this->clientes->select('clientes.*, cidade.nome AS cidade, estado.uf AS UF')
                            ->join('cidade', 'cidade.id = clientes.cidade_id', 'LEFT')
                            ->join('estado', 'estado.id = clientes.estado_id', 'LEFT')
                            ->where('clientes.id', $carrinho['cliente_id'])->first();
            $pedido['Cliente'] = [
                'cpfcnpj' => $cliente['cpf'],
                'customer_id' => $cliente['id'],
                'email' => $cliente['email'],
                'nome_completo' => $cliente['nome'],
                'telefone' => $cliente['celular'],
                'data_nascimento' => $cliente['data_nascimento']
            ];
            $pedido['Endereco_Cliente'] = [
                'address_id' => $cliente['id'],
                'bairro' => $cliente['bairro'],
                'cep' => $cliente['cep'],
                'cidade' => $cliente['cidade'],
                'complemento' => $cliente['complemento'],
                'numero' => $cliente['complemento'],
                'endereco' => $cliente['endereco'],
                'estado' => $cliente['UF']
            ];
            $pedido['Endereco_Entrega'] = [
                'address_id' => $carrinho['id'],
                'bairro' => $carrinho['bairro'],
                'cep' => $carrinho['cep'],
                'cidade' => $carrinho['cidade'],
                'complemento' => $carrinho['complemento'],
                'numero' => $carrinho['complemento'],
                'endereco' => $carrinho['endereco'],
                'estado' => $carrinho['UF']
            ];
            foreach ($this->carrinhoItens->where('carrinho_id', $carrinho['id'])->get()->getResult('array') as $k => $item) {
                $rsProd = $this->produtos->select('nome, referencia, imagem, altura, largura, comprimento, peso')->where('id', $item['produtos_id'])->first();
                $rsCor = $this->valoratributos->select('valor')->where(['produtos_tipo_atributos_id' => 1, 'id' => $item['cor_atributo_id']])->first();
                $rsTamanho = $this->valoratributos->select('valor')->where(['produtos_tipo_atributos_id' => 2, 'id' => $item['tamanho_atributo_id']])->first();
                $pedido['Itens'][] = [
                    'order_id' => "12345",
                    'order_product_id' => "00001",
                    'peso' => '0.04',
                    'preco_unit' => '398.00',
                    'product_id' => '611982441',
                    'quantidade' => 1,
                ];
                $carrinhoItens[$item['id']] = [
                    'id' => $item['id'],
                    'produtos_id' => $item['produtos_id'],
                    'produto_nome' => $rsProd['nome'],
                    'produto_imagem' => $rsProd['imagem'],
                    'cor' => $rsCor['valor'],
                    'tamanho' => $rsTamanho['valor'],
                    'quantidade' => $item['quantidade'],
                    'valor' => $item['valor'],
                    'subtotal' => $item['total']
                ];
            }

            print_r($pedido);
//            $this->carrinhoItens->select("
//                carrinho.id, 
//                clientes.nome, 
//                produto.nome,
//                produto_valor_atributos.cod_sinc, 
//                carrinho_itens.quantidade, 
//                carrinho_itens.valor, 
//                carrinho_itens.total, 
//                carrinho.tipo_frete,
//                carrinho.frete, 
//                carrinho.desconto, 
//                carrinho.subtotal, 
//                carrinho.total
//                ")
//                    ->join('produtos', 'produtos.id = carrinho_itens.produtos_id')
//                    ->join('carrinho', 'carrinho.id = carrinho_itens.carrinho_id')
//                    ->join('clientes', 'clientes.id = carrinho.cliente_id')
//                    ->join('produtos_atributos', 'produtos_atributos.id = carrinho.cliente_id')
//            ;
        }
        /*
         * 
          {
          "Pedido": [
          {
          "Cliente": {
          "cpfcnpj": "016.096.438-52",
          "customer_id": "3893",
          "email": "adm.emvarga@outlook.com",
          "nome_completo": "Raquel  Souza  Fonseca Bertolotto ",
          "telefone": "(19) 98229-2656",
          "data_nascimento": "12/04/1985"
          },
          "Endereco_Entrega": {
          "address_id": "3942",
          "bairro": "Jd Morro Branco ",
          "cep": "13483-240",
          "cidade": "Limeira ",
          "complemento": "",
          "endereco": "Rua Luís Marino Neto ",
          "estado": "SP"
          },
          "Itens": [
          {
          "order_id": "12345",
          "order_product_id": "00001",
          "peso": "0.04",
          "preco_unit": "398.00",
          "product_id": "611982441",
          "quantidade": 1,
          }
          ],
          "obs": "",
          "data": "2022-02-26 21:31:29",
          "desconto": "0.00",
          "frete": "21.00",
          "order_id": "12543",
          "order_status_id": "8",
          "parc": "0",
          "payment_code": "pagarme5",
          "payment_method": "Crédito em até 6X",
          "shipping_code": "correios.04014",
          "shipping_method": "SEDEX - Entrega em até 3 dias úteis",
          "total": "419.00"
          }
          ]
          }


          SELECT
          C.id,
          CL.nome,
          P.nome,
          CONCAT(PVA_COR.valor, '-', PVA_TAMANHO.valor) AS 'variacao',
          #	PVA_COR.valor AS 'cor',
          #	PVA_TAMANHO.valor AS 'tamanho',
          PVA_TAMANHO.cod_sinc,
          CI.quantidade,
          CI.valor,
          CI.total,
          C.tipo_frete,
          C.frete,
          C.desconto,
          C.subtotal,
          CONCAT(C.cupom, ' - ', C.cupom_valor, ' - ', C.cupom_tipo) AS cupom,
          C.total
          FROM carrinho_itens AS CI
          INNER JOIN carrinho AS C ON C.id = CI.carrinho_id
          INNER JOIN clientes AS CL ON CL.id = C.cliente_id
          INNER JOIN produtos AS P ON P.id = CI.produtos_id
          LEFT JOIN produtos_atributos AS PA_COR ON PA_COR.id = CI.cor_atributo_id AND PA_COR.produtos_id = CI.produtos_id
          LEFT JOIN produtos_valor_atributos AS PVA_COR ON PVA_COR.id = CI.cor_atributo_id
          LEFT JOIN produtos_atributos AS PA_TAMANHO ON PA_TAMANHO.id = CI.tamanho_atributo_id AND PA_TAMANHO.produtos_id = CI.produtos_id
          LEFT JOIN produtos_valor_atributos AS PVA_TAMANHO ON PVA_TAMANHO.id = CI.tamanho_atributo_id
          GROUP BY CI.id
         */
    }

}

?>