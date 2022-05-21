<style type="text/css">
    body{
        background-color: #FFFFFF !important;
    }
    .navbar {
        display: none;
    }

    .barraTopo {
        display: none;
    }

    .telaImpressao {
        width: 100%;
        background: #fff;
        position: absolute;
        top: 0px;
        left: 0px;
        padding-bottom: 30px;
        z-index: 10;
        font-size: 24px !important;
    }

    .tabelaImpressao {
        border: 1px solid #cacaca !important;
        border-radius: 10px !important;
        padding: 5px !important;
        margin-bottom: 5px !important;
        width: 100% !important;
        border-collapse: initial !important;
    }

    .tabelaImpressao tr {
        border: 1px solid black !important;
        height: 18px !important;
        font-size: .9em !important;
    }

    .tabelaImpressao tr:nth-child(even) {
        background-color: #fafafa !important;
    }

    .tabelaImpressao td {
        padding: 3px !important;
    }

    .clearfix:after {
        content: " " !important;
        visibility: hidden !important;
        display: block !important;
        height: 0 !important;
        clear: both !important;
    }

    .wrapper {
        width: 1000px !important;
        margin: 0 auto !important;
        font-size: .7em !important;
    }

    .wrapper h1 {
        border-bottom: 1px solid #cacaca !important;
        margin-bottom: 2px !important;
        font-size: 1.2em !important;
        text-transform: uppercase !important;
        text-align: center !important;
        margin-bottom: 15px !important;
        padding-bottom: 5px !important;
        line-height: normal !important;
    }

    .wrapper h3 {
        margin-bottom: 0 !important;
        font-size: 1em !important;
        line-height: normal !important;
    }

    .wrapper h3 {
        text-align: center !important;
    }

    .wrapper h4 {
        margin-top: 0 !important;
        margin-bottom: 0 !important;
        line-height: normal !important;
    }

    .head {
        background-color: #ececec !important;
        padding: 5px !important;
    }

    .email {
        margin-top: 0 !important;
        font-size: .9em !important;
    }

    .etiquetaD,
    .etiquetaR {
        max-height: 115px !important;
        font-size: 1.3em !important;
        line-height: 11px !important;
        margin-top: 5px !important;
        padding: 10px !important;
        border: 1px solid #cacaca !important;
    }

    .etiquetaD {
        width: 45% !important;
        float: left !important;
    }

    .etiquetaR {
        width: 45% !important;
        float: right !important;
    }

    .bold {
        font-weight: bold !important;
    }

    .head>td,
    .center {
        text-align: center !important;
    }

    .esquerda {
        float: left !important;
        width: 50% !important;
        font-size: 1.4em !important;
    }

    .direita {
        float: right !important;
        width: 50% !important;
        text-align: left !important;
    }

    .tb2 tr:nth-of-type(n+2) td {
        text-align: left;
        width: 50%;
    }
</style>
<div id="wrapper">
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="telaImpressao">
                <div class="wrapper">
                    <h1>:: NVIBRANCE - Relatório do pedido</h1>
                    <h3 style="margin-top:-10px;" class="clearfix">
                        <span class="esquerda">Pedido Nº <?php echo $pedido['id']; ?><br/><small>Data da compra: <?php echo date('d/m/Y H:i:s', strtotime($pedido['data_compra'])); ?></small></span>
                        <span class="direita">Status: <b><?php echo $pedido['pagamento_status']; ?></b></span>
                    </h3>
                    <table class="tabelaImpressao">
                        <tbody>
                            <tr>
                                <td class="head" colspan="2"><h4>Dados do cliente:</h4></td>
                            </tr>
                            <tr>
                                <td>Nome</td>
                                <td><?php echo $pedido['cliente_nome']; ?></td>
                            </tr>
                            <tr>
                                <td>E-mail</td>
                                <td><?php echo $pedido['cliente_email']; ?></td>
                            </tr>
                            <tr>
                                <td>CPF</td>
                                <td><?php echo $pedido['cliente_cpf']; ?></td>
                            </tr>
                            <tr>
                                <td>Telefone de Contato</td>
                                <td><?php echo $pedido['cliente_telefone']; ?></td>
                            </tr>
                            <tr>
                                <td>Telefone Celular</td>
                                <td><?php echo $pedido['cliente_celular']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="tabelaImpressao">
                        <tbody>
                            <tr>
                                <td class="head" colspan="2"><h4>Dados para entrega dos produtos:</h4></td>
                            </tr>
                            <tr>
                                <td>Endereço</td>
                                <td><?php echo $pedido['entrega_endereco']; ?>, <?php echo $pedido['entrega_numero']; ?> - <?php echo $pedido['entrega_complemento']; ?></td>
                            </tr>
                            <tr>
                                <td>Bairro</td>
                                <td><?php echo $pedido['entrega_bairro']; ?></td>
                            </tr>
                            <tr>
                                <td>Cidade</td>
                                <td><?php echo $pedido['entrega_cidade']; ?></td>
                            </tr>
                            <tr>
                                <td>Estado</td>
                                <td><?php echo $pedido['entrega_uf']; ?></td>
                            </tr>
                            <tr>
                                <td>CEP</td>
                                <td><?php echo $pedido['entrega_cep']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="tabelaImpressao">
                        <tbody>
                            <tr class="head bold center">
                                <td></td>
                                <td>Código ERP</td>
                                <td>Produto</td>
                                <td>Referência</td>
                                <td>Cor</td>
                                <td>Tamanho</td>
                                <td>Quantidade</td>
                                <td>Preço</td>
                                <td>Sub-total</td>
                            </tr>
                            <?php foreach ($pedido_itens as $key => $item) : ?>
                            <tr class="head">
                                <td>
                                    <a href="<?php echo base_url('public/upload/produtos/thumb_1200/' . $item['imagem']); ?>" class="fancybox">
                                        <figure class="bg-cover bg-p75" style="width: 50px;"><img src="<?php echo base_url('public/upload/produtos/thumb_1200/' . $item['imagem']); ?>" /></figure>
                                    </a>
                                </td>
                                <td><?php echo $item['cod_sinc']?></td>
                                <td><?php echo $item['nome']?></td>
                                <td><?php echo $item['referencia']?></td>
                                <td><?php echo $item['cor']?></td>
                                <td><?php echo $item['tamanho']?></td>
                                <td><?php echo $item['quantidade']?></td>
                                <td>R$ <?php echo $item['valor']?></td>
                                <td>R$ <?php echo $item['total']?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <table class="tabelaImpressao tb2">
                        <tbody>
                            <tr>
                                <td class="head" colspan="2"><h4>Valores</h4></td>
                            </tr>
                            <tr>
                                <td>Total em produtos:</td>
                                <td>R$ <?php echo $pedido['subtotal']?></td>
                            </tr>
                            <tr>
                                <td>Desconto por forma de pagamento escolhida:</td>
                                <td>- R$ <?php echo $pedido['desconto']?></td>
                            </tr>
                            <tr>
                                <td>Valor do frete:</td>
                                <td><?php echo $pedido['frete']?> (<?php echo $pedido['tipo_frete']?>)</td>
                            </tr>
                            <tr>
                                <td>Total da compra:</td>
                                <td>R$ <?php echo $pedido['total']?></td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="tabelaImpressao tb2">
                        <tbody>
                            <tr>
                                <td class="head" colspan="2"><h4>Pagamento: <b><?php echo $pedido['pagamento']?></b></h4></td>
                            </tr>
                            <tr>
                                <td>Forma de Pagamento:</td>
                                <td><?php echo $pedido['pagamento']?></td>
                            </tr>
                            <tr>
                                <td>Parcelamento:</td>
                                <td><?php echo $pedido['parcelas']?>x</td>
                            </tr>
                            <tr>
                                <td>Total a Pagar:</td>
                                <td>R$ <?php echo $pedido['total']?></td>
                            </tr>
                            <tr>
                                <td>Status do Pagamento:</td>
                                <td class="bold"><?php echo $pedido['pagamento_status']?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
