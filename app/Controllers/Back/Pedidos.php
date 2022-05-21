<?php

namespace App\Controllers\Back;

use App\Controllers\BaseController;
use App\Models\Back\SiteModel;
use App\Models\Back\ProdutosModel;
use App\Models\Back\ProdutosValorAtributosModel;
use App\Models\Front\CarrinhoModel;
use App\Models\Front\CarrinhoItensModel;
use App\Models\Front\ClientesModel;

class Pedidos extends BaseController {

    protected $pedidos;
    protected $clientes;
    protected $sites;
    protected $data;

    public function __construct() {
        helper(['url', 'form']);

        $this->carrinho = new CarrinhoModel();
        $this->clientes = new ClientesModel();
        $this->sites = new SiteModel();
        $this->data = [
            'sites' => $this->sites->whereIn('id', ['1', '2', '3'])->get()->getResult('array')
        ];
    }

    public function index() {
        $this->data['pedidos'] = $this->carrinho
                        ->select('carrinho.id, carrinho.total, carrinho.pagamento, carrinho.pagamento_status, carrinho.data_compra, clientes.nome AS cliente_nome')
                        ->join('clientes', 'clientes.id = carrinho.cliente_id')
                        ->where('data_compra IS NOT NULL')
                        ->get()->getResult('array');
        echo view('Back/Pedidos/index', $this->data);
    }

    public function detalhes($id) {
        $this->produtos = new ProdutosModel();
        $this->carrinhoItens = new CarrinhoItensModel();
        $this->valoratributos = new ProdutosValorAtributosModel();

        $this->data['pedido'] = $this->carrinho
                ->select(''
                        . ' clientes.nome AS cliente_nome, clientes.email AS cliente_email, clientes.cpf AS cliente_cpf, clientes.telefone AS cliente_telefone, clientes.celular AS cliente_celular,'
                        . ' carrinho.cep AS entrega_cep, carrinho.endereco AS entrega_endereco, carrinho.numero AS entrega_numero, carrinho.complemento AS entrega_complemento,'
                        . ' cidade.nome AS entrega_cidade, estado.uf AS entrega_uf, carrinho.bairro AS entrega_bairro, '
                        . ' carrinho.id, carrinho.pagamento, carrinho.pagamento_status, carrinho.data_compra, '
                        . ' carrinho.subtotal, carrinho.total, carrinho.desconto, carrinho.frete, carrinho.tipo_frete,  carrinho.parcelas')
                ->join('clientes', 'clientes.id = carrinho.cliente_id')
                ->join('estado', 'estado.id = carrinho.estado_id')
                ->join('cidade', 'cidade.id = carrinho.cidade_id')
                ->where(['carrinho.id' => $id])
                ->first();
        foreach ($this->carrinhoItens->where('carrinho_id', $id)->get()->getResult('array') as $k => $item) {
            $rsProd = $this->produtos->select('cod_sinc, nome, referencia, imagem, altura, largura, comprimento, peso')->where('id', $item['produtos_id'])->first();
            $rsCor = $this->valoratributos->select('valor')->where(['produtos_tipo_atributos_id' => 1, 'id' => $item['cor_atributo_id']])->first();
            $rsTamanho = $this->valoratributos->select('valor')->where(['produtos_tipo_atributos_id' => 2, 'id' => $item['tamanho_atributo_id']])->first();
            $this->data['pedido_itens'][] = [
                'imagem' => $rsProd['imagem'],
                'cod_sinc' => $rsProd['cod_sinc'],
                'nome' => $rsProd['nome'],
                'referencia' => $rsProd['referencia'],
                'cor' => $rsCor['valor'],
                'tamanho' => $rsTamanho['valor'],
                'quantidade' => $item['quantidade'],
                'valor' => $item['valor'],
                'total' => $item['total']
            ];
        }


        echo view('Back/_head');
        echo view('Back/Pedidos/detalhes', $this->data);
        echo view('Back/_footer');
    }

}
