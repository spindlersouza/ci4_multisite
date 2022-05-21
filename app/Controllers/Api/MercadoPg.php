<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Back\ConfiguracaoModel;
use App\Models\Back\ProdutosModel;
use App\Models\Back\EstadoModel;
use App\Models\Back\CidadeModel;
use App\Models\Front\ClientesModel;
use App\Models\Front\CarrinhoModel;
use App\Models\Front\CarrinhoItensModel;
use App\Models\Back\SiteModel;

class MercadoPg extends BaseController {

    protected $configs;
    protected $sites;
    protected $produtos;
    protected $cliente;
    protected $carrinho;
    protected $carrinhoItens;
    protected $estado;
    protected $cidade;
    protected $data;

    //TEST-c95303fa-246f-4452-bde3-f128ca706a6c
    //TEST-8347530394140898-031119-285b2a940c7d2bb687d625d4eb4b3e63-157317792
    //PK -> APP_USR-76ebbf7d-27e9-4139-8fa9-a9ddba08deb0
    //AT -> APP_USR-8347530394140898-031119-5050f53fc9c8c8b426a5869473beec58-157317792
    //CID -> 8347530394140898
    //CS -> 7uIpWx4nn1agLgUXLBbRTWIVncD33sma

    public function __construct() {
        $this->configs = new ConfiguracaoModel();
        $this->sites = new SiteModel();
        $this->produtos = new ProdutosModel();
        $this->cliente = new ClientesModel();
        $this->carrinho = new CarrinhoModel();
        $this->carrinhoItens = new CarrinhoItensModel();
        $this->estado = new EstadoModel();
        $this->cidade = new CidadeModel();
        $this->data = [
            'slug' => SITESLUG,
            'site_id' => SITEENABLED,
            'configs' => $this->configs->select('cep_remetente, frenet_token')->where('site_id', SITEENABLED)->first(),
        ];
        $this->data['status_p'] = [
            'pending' => 'Pendente',
            'approved' => 'Aprovado',
            'authorized' => 'Autorizado',
            'in_process' => 'Em análise',
            'in_mediation' => 'Em disputa',
            'rejected' => 'Recusado',
            'cancelled' => 'Cancelado',
            'refunded' => 'Devolvido',
            'charged_back' => 'Estornado'
        ];
    }

    public function MeiosPagamento() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.mercadopago.com/v1/payment_methods");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Accept: application/json",
            "Authorization: Bearer APP_USR-8347530394140898-031119-5050f53fc9c8c8b426a5869473beec58-157317792"
//        "Authorization: Bearer TEST-8347530394140898-031119-285b2a940c7d2bb687d625d4eb4b3e63-157317792"
        ));

        $response = json_decode(curl_exec($ch), true);

        curl_close($ch);
//        print_r($response);
//        return $response;
    }

    public function pagamentocc() {

        $pay = json_decode($this->request->getBody(), TRUE);

        $carrinho = $this->carrinho->where('id', $_COOKIE['cart'])->first();
        $carrinho['desconto'] = $carrinho['desconto'] ?? 0;
        $carrinho['total'] = $carrinho['subtotal'] + $carrinho['frete'] - $carrinho['desconto'];
        $carrinhoItens = $this->carrinhoItens->where('carrinho_id', $_COOKIE['cart'])->get()->getResult('array');
        foreach ($carrinhoItens as $item) {
            $rsProd = $this->produtos
                    ->select('produtos.nome, produtos.descricao_simplificada, produtos.imagem, produtos_categorias.nome AS categoria')
                    ->join('produtos_categorias', 'produtos_categorias.id = produtos.produtos_categorias_id')
                    ->where(['produtos.id' => $item['produtos_id']])
                    ->first();

            $mppg['additional_info']['items'][] = [
                'id' => $item['produtos_id'],
                'title' => $rsProd['nome'],
                'category_id' => 'fashion',
                'quantity' => $item['quantidade'],
                'unit_price' => $item['valor'],
            ];
        }

        $mppg['additional_info']['shipments']['receiver_address'] = [
            'zip_code' => str_replace('-', '', $carrinho['cep']),
            'street_name' => $carrinho['endereco'],
            'street_number' => $carrinho['numero']
        ];

        $mppg['description'] = 'Instinto Intimo';

        $cliente = $this->cliente->select('nome, email, cpf, telefone, celular, cep, endereco, numero, bairro, created_at')->where(['id' => $carrinho['cliente_id']])->first();
        $nomeCliente = explode(' ', $cliente['nome']);

        $mppg['additional_info']['payer'] = [
            'first_name' => $nomeCliente[0],
            'last_name' => str_replace($nomeCliente[0], '', $cliente['nome']),
        ];
        $mppg['additional_info']['payer']['phone'] = [
            'area_code' => '00',
            'number' => ($cliente['telefone'] != '') ? $cliente['telefone'] : $cliente['celular'],
        ];
        $mppg['additional_info']['payer']['address'] = [
            'zip_code' => $cliente['cep'],
            'street_name' => $cliente['endereco'],
            'street_number' => $cliente['numero'],
        ];

        $mppg['payer'] = [
            'email' => $cliente['email'],
            'first_name' => $nomeCliente[0],
            'last_name' => str_replace($nomeCliente[0], '', $cliente['nome']),
        ];
        $mppg['payer']['identification'] = [
            'type' => 'CPF',
            'number' => str_replace(['.', '-'], '', $cliente['cpf'])
        ];
        $mppg['payer']['address'] = [
            'zip_code' => $cliente['cep'],
            'street_name' => $cliente['endereco'],
            'street_number' => $cliente['numero'],
            'city' => $this->cidade->select('nome')->where(['id' => $cliente['cidade_id']])->first()['nome'],
            'neighborhood' => $cliente['bairro'],
            'federal_unit' => $this->estado->select('nome')->where(['id' => $cliente['estado_id']])->first()['nome'],
        ];

        $mppg['payment_method_id'] = $pay['paymentMethodId'];
        $mppg['issuer_id'] = $pay['issuerId'];
        $mppg['installments'] = (int) $pay['installments'];
        $mppg['transaction_amount'] = (float) number_format($carrinho['total'], 2, '.', '');
        $mppg['token'] = $pay['token'];
        $carrinho['envio_mp'] = json_encode($mppg);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.mercadopago.com/v1/payments");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($mppg));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Accept: application/json",
            "Authorization: Bearer APP_USR-8347530394140898-031119-5050f53fc9c8c8b426a5869473beec58-157317792"
        ));
        $response = curl_exec($ch);
        $ret = json_decode($response, TRUE);
        curl_close($ch);
        if (isset($ret['error']) || (in_array($ret['status'], ['rejected', 'cancelled', '400']))) {
            session()->setFlashdata(['erro_pagamento' => 'Erro no pagamento']);
        } else {
            $carrinho['pagamento'] = 'cartao';
            $carrinho['pagamento_status'] = $this->data['status_p'][$ret['status']];
            $carrinho['transaction'] = $ret['id'];
            $carrinho['data_compra'] = date('Y-m-d H:i:s');
            setcookie('cart', null, -1, '/');
        }

        $carrinho['retorno_mp'] = $response;
        $this->carrinho->save($carrinho);
        return $response;
    }

    public function pagamentoboleto() {
        $carrinho = $this->carrinho->where('id', $_COOKIE['cart'])->first();
        $carrinho['desconto'] = $carrinho['desconto'] ?? 0;
        $carrinho['total'] = $carrinho['subtotal'] + $carrinho['frete'] - $carrinho['desconto'];
        $carrinhoItens = $this->carrinhoItens->where('carrinho_id', $_COOKIE['cart'])->get()->getResult('array');
        foreach ($carrinhoItens as $item) {
            $rsProd = $this->produtos
                    ->select('produtos.nome, produtos.descricao_simplificada, produtos.imagem, produtos_categorias.nome AS categoria')
                    ->join('produtos_categorias', 'produtos_categorias.id = produtos.produtos_categorias_id')
                    ->where(['produtos.id' => $item['produtos_id']])
                    ->first();

            $mppg['additional_info']['items'][] = [
                'id' => $item['produtos_id'],
                'title' => $rsProd['nome'],
                'category_id' => 'fashion',
                'quantity' => $item['quantidade'],
                'unit_price' => $item['valor'],
            ];
        }
        $cliente = $this->cliente->select('nome, email, cpf, telefone, celular, cep, endereco, numero, bairro, created_at')->where(['id' => $carrinho['cliente_id']])->first();
        $nomeCliente = explode(' ', $cliente['nome']);
        $mppg['additional_info']['payer'] = [
            'first_name' => $nomeCliente[0],
            'last_name' => str_replace($nomeCliente[0], '', $cliente['nome']),
        ];
        $mppg['additional_info']['payer']['phone'] = [
            'area_code' => '00',
            'number' => ($cliente['telefone'] != '') ? $cliente['telefone'] : $cliente['celular'],
        ];
        $mppg['additional_info']['payer']['address'] = [
            'zip_code' => $cliente['cep'],
            'street_name' => $cliente['endereco'],
            'street_number' => $cliente['numero'],
        ];

        $mppg['additional_info']['shipments']['receiver_address'] = [
            'zip_code' => str_replace('-', '', $carrinho['cep']),
            'street_name' => $carrinho['endereco'],
            'street_number' => $carrinho['numero']
        ];

        $mppg['description'] = 'Instinto Intimo';

        $mppg['payer'] = [
            'email' => $cliente['email'],
            'first_name' => $nomeCliente[0],
            'last_name' => str_replace($nomeCliente[0], '', $cliente['nome']),
        ];
        $mppg['payer']['identification'] = [
            'type' => 'CPF',
            'number' => str_replace(['.', '-'], '', $cliente['cpf'])
        ];
        $mppg['payer']['address'] = [
            'zip_code' => $cliente['cep'],
            'street_name' => $cliente['endereco'],
            'street_number' => $cliente['numero'],
            'city' => $this->cidade->select('nome')->where(['id' => $cliente['cidade_id']])->first()['nome'],
            'neighborhood' => $cliente['bairro'],
            'federal_unit' => $this->estado->select('nome')->where(['id' => $cliente['estado_id']])->first()['nome'],
        ];

        $mppg['payment_method_id'] = 'bolbradesco';
        $mppg['transaction_amount'] = (float) number_format($carrinho['total'], 2, '.', '');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.mercadopago.com/v1/payments");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($mppg));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Accept: application/json",
            "Authorization: Bearer APP_USR-8347530394140898-031119-5050f53fc9c8c8b426a5869473beec58-157317792"
        ));
        $response = curl_exec($ch);
        $ret = json_decode($response, TRUE);
        curl_close($ch);
        if (isset($ret['error'])) {
            session()->setFlashdata(['erro_pagamento' => 'Erro no pagamento']);
            $carrinho['retorno_mp'] = $response;
            $this->carrinho->save($carrinho);
            return redirect()->to('/pagamento');
        }
        $carrinho['linha_digitavel'] = $ret['barcode']['content'];
        $carrinho['link_boleto'] = $ret['transaction_details']['external_resource_url'];
        $carrinho['pagamento'] = 'boleto';
        $carrinho['pagamento_status'] = $this->data['status_p'][$ret['status']];
        $carrinho['transaction'] = $ret['id'];
        $carrinho['data_compra'] = date('Y-m-d H:i:s');
        $carrinho['retorno_mp'] = $response;
        $this->carrinho->save($carrinho);
        setcookie('cart', null, -1, '/');

        $config = $this->configs->where('site_id', SITEENABLED)->first();
        $htmlMsg = ''
                . ' <section class="border border-gray my-5">'
                . '     <div style="max-width: 850px; margin: 0 10%;">'
                . '         <img src="' . base_url('public/upload/configs/' . $config['email_cabecalho']) . '" style="width: 100%;">'
                . '         <br><br>'
                . '         <span>' . date('d/m/Y - H:i') . '</span>'
                . '         <br><br>'
                . '         <h3>Confirmação de pedido realizado - Número: #' . $carrinho['id'] . '</h3>'
                . '         <br><br><br>'
                . '         <p>'
                . '             <b>Prezado(a) Cliente ' . $cliente['nome'] . ',</b><br> '
                . '             A compra que você realizou está sendo processada e assim que identificarmos o seu pagamento o seu pedido será separado para entrega ou para retirada na loja, caso você tenha optado. <br><br>'
                . '             Esta mensagem é exclusiva à pessoa a quem foi destinada, podendo haver informações confidenciais e/ou legalmente protegidas. '
                . '             Se você não for o destinatário, é notificado que não deve fazer cópias, divulgações, verificações ou qualquer outro ato de mesma espécie, '
                . '             com o objetivo de utilizar estas informações. Por favor, caso tenha havido o engano, desde já, é importante que remova as informações de seus servidores e/ou banco de dados, '
                . '             precavendo-se assim de acarretamentos legais.<br><br>'
                . '         </p>'
                . '         <br><br>'
                . '         <p> <a href="' . $carrinho['link_boleto'] . '" target="_blank"> LINK PARA O BOLETO </a> </p>'
                . '         <br><br>'
                . '         <p> Equipe :: Grupo Instinto Íntimo<br>Copyright © 2022 - TODOS OS DIREITOS RESERVADOS</p><br>'
                . '         <img src="' . base_url('public/upload/configs/' . $config['email_rodape']) . '" alt="" style="width: 100%;">'
                . '     </div>'
                . ' </section>';

        $configs['protocol'] = 'smtp';
        $configs['SMTPHost'] = $config['email_smtp'];
        $configs['SMTPPort'] = $config['email_smtp_porta'];
        $configs['smtp_timeout'] = '7';
        $configs['SMTPUser'] = $config['email_usuario'];
        $configs['SMTPPass'] = $config['email_senha'];
        $configs['charset'] = 'utf-8';
        $configs['newline'] = "\r\n";
        $configs['mailtype'] = 'html';
        $configs['validation'] = FALSE;
        $email = new \CodeIgniter\Email\Email($configs);
        $email->setFrom($config['email_usuario'], 'Grupo Instinto Intimo');
        $email->setTo($cliente['email']);
        if ($configs['email_notificacao_copia_oculta'] != '') {
            $email->setCC($configs['email_notificacao_copia']);
        }
        if ($configs['email_notificacao_copia_oculta'] != '') {
            $email->setBCC($configs['email_notificacao_copia_oculta']);
        }
        $email->setSubject('Confirmação de compra');
        $email->setMessage($htmlMsg);
        $email->mailType = 'html';
        if (!$email->send()) {
            
        }

        session()->setFlashdata(['pagamento_ok' => 'boleto']);
        return redirect()->to('/meuspedidos');
    }

    public function testeemail() {
        $config = $this->configs->where('site_id', SITEENABLED)->first();
        $htmlMsg = ''
                . ' <section class="border border-gray my-5">'
                . '     <div style="max-width: 850px; margin: 0 10%;">'
                . '         <img src="' . base_url('public/upload/configs/' . $config['email_cabecalho']) . '" style="width: 100%;">'
                . '         <br><br>'
                . '         <span>' . date('d/m/Y - H:i') . '</span>'
                . '         <br><br>'
                . '         <h3>Confirmação de pedido realizado - Número: #' . $carrinho['id'] . '</h3>'
                . '         <br><br><br>'
                . '         <p>'
                . '             <b>Prezado(a) Cliente ' . $cliente['nome'] . ',</b><br> '
                . '             A compra que você realizou está sendo processada e assim que identificarmos o seu pagamento o seu pedido será separado para entrega ou para retirada na loja, caso você tenha optado. <br><br>'
                . '             Esta mensagem é exclusiva à pessoa a quem foi destinada, podendo haver informações confidenciais e/ou legalmente protegidas. '
                . '             Se você não for o destinatário, é notificado que não deve fazer cópias, divulgações, verificações ou qualquer outro ato de mesma espécie, '
                . '             com o objetivo de utilizar estas informações. Por favor, caso tenha havido o engano, desde já, é importante que remova as informações de seus servidores e/ou banco de dados, '
                . '             precavendo-se assim de acarretamentos legais.<br><br>'
                . '         </p>'
                . '         <br><br>'
                . '         <p> Equipe :: Grupo Instinto Íntimo<br>Copyright © 2022 - TODOS OS DIREITOS RESERVADOS</p><br>'
                . '         <img src="' . base_url('public/upload/configs/' . $config['email_rodape']) . '" alt="" style="width: 100%;">'
                . '     </div>'
                . ' </section>';

        $configs['protocol'] = 'smtp';
        $configs['SMTPHost'] = $config['email_smtp'];
        $configs['SMTPPort'] = $config['email_smtp_porta'];
        $configs['smtp_timeout'] = '7';
        $configs['SMTPUser'] = $config['email_usuario'];
        $configs['SMTPPass'] = $config['email_senha'];
        $configs['charset'] = 'utf-8';
        $configs['newline'] = "\r\n";
        $configs['mailtype'] = 'html';
        $configs['validation'] = FALSE;
        $email = new \CodeIgniter\Email\Email($configs);
        $email->setFrom($config['email_usuario'], 'Grupo Instinto Intimo');
        $email->setTo('spindlersouza@gmail.com');
//        $email->setSubject('Teste àÀáÁ &aacute;&Aacute;');
        $email->setSubject('Confirmacao de compra');
        $email->setMessage($htmlMsg);
        $email->mailType = 'html';
//        if ($this->request->getFile('arquivos')) {
//            //TESTAR MAIS RENOMEANDO ARQUIVO 
//            //TMP SAVE
//            $file = $this->request->getFile('arquivos');
//            $email->attach($file->getName());
//        }
        if (!$email->send()) {
            dd($email->printDebugger());
        }
    }

}
