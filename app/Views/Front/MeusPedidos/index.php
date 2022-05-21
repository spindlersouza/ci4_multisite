<?php echo $this->extend('front'); ?>
<?php echo $this->section('content'); ?>

<!-- conteúdo -->
<section class="py-5 border-top slider-banner">
    <div class="">
        <div class="row mx-3">
            <div class="col-12 mb-4">
                <a href="<?php echo base_url('minha-conta'); ?>" class="btn btn-secondary rounded-0 pull-left">Voltar</a>
            </div>
            <div class="col-12 tabela-meus-pedidos">
                <h3 class="text-uppercase">Meus Pedidos</h3>
                <div class="clearfix"></div>
                <br />
                <div class="table-responsive no-tables">
                    <?php if ($pedidos) : ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-uppercase">Pedido</th>
                                    <th class="text-uppercase text-center">Data</th>
                                    <th class="text-uppercase text-center">Produtos</th>
                                    <th class="text-uppercase text-center">Frete</th>
                                    <th class="text-uppercase text-center">Desconto</th>
                                    <th class="text-uppercase text-center">Total</th>
                                    <th class="text-uppercase text-center">Pagamento</th>
                                    <th class="text-uppercase text-center">Status</th>
                                    <th class="text-uppercase text-center">Situação e Rastreio</th>
                                    <th class="text-uppercase text-center">Visualizar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pedidos as $pedido) : ?>
                                    <tr>
                                        <td data-title="Pedido"><p><b class="text-color">#<?php echo $pedido['id']; ?></b></p></td>
                                        <td data-title="Data"><p class="text-center"><?php echo $pedido['data_compra']; ?></p></td>
                                        <td data-title="Produtos"><p class="text-center">R$ <?php echo $pedido['subtotal']; ?></p></td>
                                        <td data-title="Frete"><p class="text-center">R$ <?php echo $pedido['frete']; ?></p></td>
                                        <td data-title="Desconto"><p class="text-center"><?php echo $pedido['desconto']; ?></p></td>
                                        <td data-title="Total"><p class="text-center"><b>R$ <?php echo $pedido['total']; ?></b></p></td>
                                        <td data-title="Pagamento"><p class="text-center">R$ <?php echo $pedido['pagamento']; ?></p></td>
                                        <td data-title="Status"><p class="text-center"><?php echo $pedido['pagamento_status']; ?></p></td>
                                        <td data-title="Situação"><p class="text-center"><?php echo $pedido['pagamento_status']; ?></p></td>
                                        <td data-title="Visualizar">
                                            <p class="text-center">
                                                <a class="btn btn-default btn-xs" data-toggle="modal" data-target="#modal-pedido<?php echo $pedido['id']; ?>" href="#">
                                                    <i class="fa fa-shopping-basket"></i>
                                                </a>
                                            </p>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- modal  -->
<?php if ($pedidos) : ?>
    <?php foreach ($pedidos as $pedido) : ?>

        <div class="modal fade modal-form" id="modal-pedido<?php echo $pedido['id']; ?>" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <p class="h5">PEDIDO nº: #<?php echo $pedido['id']; ?></p>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body row">
                        <div class="col-12">
                            <div class="table-responsive no-tables">
                                <table class="table-pedido table table-striped">
                                    <tbody>
                                        <tr>
                                            <td data-title="Forma de Pag.">
                                                <?php if ($pedido['pagamento'] == 'boleto') : ?>
                                                    <p>&nbsp;&nbsp;&nbsp;<a href="<?php echo $pedido['link_boleto']; ?>" class="btn btn-sm btn-default" target="_blank"><i class="fa fa-barcode"></i>&nbsp;&nbsp;Visualizar Boleto</a> </p>
                                                <?php else : ?>
                                                    <p>&nbsp;&nbsp;&nbsp;Cartão</p>
                                                <?php endif; ?>
                                            </td>
                                            <?php if ($pedido['pagamento'] != 'boleto') : ?>
                                                <td data-title="Parcelamento">
                                                    <p class="text-center"><?php if ($pedido['pagamento'] != 'boleto' && $pedido['parcelas'] != '') : ?> <?php echo $pedido['parcelas']; ?>x<?php endif; ?></p>
                                                </td>
                                            <?php endif; ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive no-tables">
                                <table class="table-pedido table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase">Produto</th>
                                            <th class="text-uppercase">Detalhes</th>
                                            <th class="text-uppercase text-center">Quantidade</th>
                                            <th class="text-uppercase text-center text-nowrap">Valor Unit.</th>
                                            <th class="text-uppercase text-center">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($pedidoItens[$pedido['id']] as $item) : ?>
                                            <tr>
                                                <td class="text-nowrap">
                                                    <p>
                                                        <b class="text-uppercase"><?php echo $item['produto_nome']; ?></b>
                                                        <br />
                                                        <b>Referência:</b> <?php echo $item['produto_referencia']; ?>
                                                    </p>
                                                </td>
                                                <td class="text-nowrap">
                                                    <p>

                                                        <b>Cor:</b> <?php echo $item['produto_cor']; ?>
                                                        <br />
                                                        <b>Tamanho:</b> <?php echo $item['produto_tamanho']; ?>
                                                        <br />

                                                    </p>
                                                </td>
                                                <td data-title="Quantidade">
                                                    <p class="text-center">
                                                        <?php echo $item['quantidade']; ?>
                                                    </p>
                                                </td>
                                                <td data-title="Valor Unit.">
                                                    <p class="text-center">
                                                        R$ <?php echo $item['valor']; ?>
                                                    </p>
                                                </td>
                                                <td data-title="Subtotal">
                                                    <p class="text-center">
                                                        R$ <?php echo $item['subtotal']; ?>
                                                    </p>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
<?php if (session()->getFlashdata('pagamento_ok') == 'boleto') : ?>
    <!-- alerta boleto -->
    <div id="Boleto" class="add_carrinho anime-down" >
        <a class="text-light p-2" href="javascript:void(0);" onclick="BoletoClose()"> <span>X</span></a>
        <h5 class="text-light">
            Pronto! Você receberá o boleto que acabou de gerar no e-mail cadastrado em sua conta!<br>
            Efetue o pagamento para validar a sua compra. Obrigada por escolher a VIBRANCE! \0/ \0/</h5>
    </div>
<?php endif; ?>

<?php echo $this->endSection(); ?>