<?php echo $this->extend('front'); ?>
<?php echo $this->section('content'); ?>
<div class="d-none" style="display:none;"> 
    <input type="hidden" id="ftgt" value="<?php echo $fretegratis; ?>" />
    <input type="hidden" id="ftc" value="<?php echo ($carrinho['subtotal'] < $fretegratis); ?>" />
    <?php print_r($carrinho); ?>

</div>
<!-- conteúdo  -->
<div class="slider-banner border-top" style="height: 5px;"></div>
<section class="mb-5">
    <div class="">
        <div class="row mx-3 px-2 px-md-0 mt-4">
            <?php if ($fretegratis > 0) : ?>
                <div class="col-12 bg-custom my-4 py-2">
                    <p class="text-dark text-center">ACIMA DE <b> R$ <?php echo number_format($fretegratis, 2, ',', '.'); ?></b> O SEU FRETE É GRÁTIS!<br>
                        <?php if ($carrinho['subtotal'] < $fretegratis) : ?>
                            ADICIONE + <b>R$ <?php echo number_format((float) $fretegratis - $carrinho['subtotal'], 2, ',', '.'); ?></b> EM PRODUTOS NO SEU CARRINHO E GANHE O FRETE GRÁTIS!
                        <?php endif; ?>
                    </p>
                </div>
            <?php endif;
            ?>
            <?php if ($carrinho_itens) : ?>
                <table class="col-12 border-all cart-table mt-4">
                    <thead>
                        <tr class="thead-none">
                            <th class="text-uppercase px-3 ">Produto</th>
                            <th></th>
                            <th class="text-uppercase text-center">Quantidade</th>
                            <th class="text-uppercase text-center text-nowrap">Valor Unit.</th>
                            <th class="text-uppercase text-center">Subtotal</th>
                            <th class="text-uppercase text-center">Remover</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($carrinho_itens as $item) : ?>
                            <tr class="border-top" id="produtocarrinho<?php echo $item['id']; ?>">
                                <td class="table-coluna text-center text-md-left">
                                    <img class="img-fit-cart" src="<?php echo base_url('public/upload/produtos/thumb_200/' . $item['produto_imagem']); ?>" />
                                </td>
                                <td class="text-nowrap table-coluna text-center text-md-left">
                                    <p>
                                        <b class="text-uppercase"><?php echo $item['produto_nome']; ?></b><br />
                                        <b>Cor: </b><?php echo $item['cor']; ?><br />
                                        <b>Tamanho: </b><?php echo $item['tamanho']; ?><br />
                                    </p>
                                </td>
                                <td class="table-coluna center-center">
                                    <div class="num-block skin-2 my-1 mx-0">
                                        <div id="qtdCarrinhoProds<?php echo $item['id']; ?>" class="num-in">
                                            <span data-id="<?php echo $item['id']; ?>" class="minus dis minus_produto_carrinho"></span>
                                            <input type="text" id="produto_quantidade<?php echo $item['id']; ?>" class="in-num" value="<?php echo $item['quantidade']; ?>" readonly="">
                                            <span data-id="<?php echo $item['id']; ?>" class="plus plus_produto_carrinho"></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="table-coluna" data-title="Valor Unit.">
                                    <p class="text-center text-color">R$ <?php echo number_format($item['valor'], 2, ',', '.'); ?></p>
                                </td>
                                <td class="table-coluna" data-title="Subtotal">
                                    <p class="text-center text-color" id="subtotal_item_carrinho<?php echo $item['id']; ?>">R$ <?php echo number_format($item['subtotal'], 2, ',', '.'); ?></p>
                                </td>
                                <td class="table-coluna">
                                    <form method="post" action="" class="form-remove-carrinho text-center my-2">
                                        <button class="remover-produto btn btn-primary btn-xs" onclick="removeprodutocarrinho(<?php echo $item['id']; ?>)" type="button"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

        <div class="row mx-3 my-4 px-2 px-md-0">
            <table class="col-12 border-all cart-table">
                <thead class="border-bottom">
                    <tr class="thead-none">
                        <th class="text-uppercase px-3 ">Endereço de Entrega</th>
                        <th class="text-uppercase px-3 ">Frete</th>
                        <th class="text-uppercase px-3 "> Cupom de Desconto </th>
                        <th class="text-uppercase px-3  text-right">Totais</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <!-- ENDEREÇO  -->
                        <td class="px-3 table-coluna">
                            <?php if (session()->has('cliente_id')): ?>
                                <h2 class="d-block d-lg-none mt-4 border-top">Endereço de Entrega</h2>
                                <p class="text-uppercase">Endereço Cadastrado</p>
                                <p>
                                    <b>
                                        <?php if ($endereco) : ?>
                                            <?php echo $carrinho['endereco'] . ' ' . $carrinho['numero']; ?>,<br>
                                            Bairro <?php echo $carrinho['bairro']; ?><br>
                                            <?php echo $carrinho['cidade'] . ' - ' . $carrinho['estado']; ?> <br>
                                            CEP <?php echo $carrinho['cep']; ?><br>
                                        <?php endif; ?>
                                    </b>
                                </p>

                                <p></p>
                                <p><a class="btn btn-secondary rounded-0 btn-sm" data-toggle="modal" data-target="#modal-endereco-alternativo" href="#" onclick="">ALTERAR</a></p>
                                <br />
                            <?php endif; ?>
                        </td>
                        <!-- FRETE  -->
                        <td class="px-3 table-coluna">
                            <h2 class="d-block d-lg-none mt-4 border-top">Frete</h2>
                            <div class="form-group col-12 col-md-8 my-2 px-0">
                                <p class="my-2">INSIRA O CEP PARA ENTREGA:</p>
                                <div class="d-flex">
                                    <input type="text" id="cepFreteCarrinho" class="form-control codigo-cupom input-upper cep-mask rounded-0" placeholder="CEP" value="<?php echo $carrinho['cep']; ?>" style="background: #ddd;">
                                    <button class="form-control codigo-cupom input-upper rounded-0 p-0" style="height: 49px;" id="busca_frete_carrinho">Consultar</button>
                                </div>
                            </div>
                            <div id="lista_fretes_carrinho" class="mt-3 p-1">
                                <?php if ($carrinho['lista_frete']) : ?>
                                    <p class="text-uppercase">Selecione a forma de entrega:</p>
                                    <?php foreach ($carrinho['lista_frete'] as $frete) : ?>
                                        <div class="radio">
                                            <input type="radio" name="rdfrete" id="frete-<?php echo $frete['tipo']; ?>" value="<?php echo $frete['tipo']; ?>" data-valor="<?php echo $frete['preco']; ?>" class="radio-frete" required>
                                            <label for="frete-<?php echo $frete['tipo']; ?>"><?php echo $frete['tipo']; ?> = <b> R$ <?php echo $frete['preco']; ?></b></label>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </td>
                        <!-- CUPOM  -->
                        <td class="px-3 table-coluna">
                            <h2 class="d-block d-lg-none mt-4 border-top">Cupom de Desconto</h2>
                            <div class="form-group col-12 col-md-8 p-0">
                                <p> POSSUI UM CUPOM DE DESCONTO?<br /> INFORME O CÓDIGO ABAIXO!</p>
                                <div class="my-2 d-flex">
                                    <input type="text" id="codigo_cupom" class="form-control codigo-cupom input-upper rounded-0" placeholder="Código" value="<?php echo $carrinho['cupom']; ?>" style="background: #ddd;">
                                    <button class="form-control codigo-cupom input-upper rounded-0" style="width: 50px; height: 49px;" id="cupomCarrinho">OK</button>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="label-cupom">
                                <?php if ($carrinho['cupom'] != '') : ?>
                                    <p>
                                        <b class="text-success text-uppercase">Cupom OK!</b><br />
                                        Cupom: <b> <?php echo $carrinho['cupom']; ?></b><br />
                                        Desconto: <b> <?php echo ($carrinho['cupom_tipo'] == 1) ? $carrinho['cupom_valor'] . '%' : 'R$ ' . $carrinho['cupom_valor']; ?></b><br />
                                    </p>
                                <?php endif; ?>
                                <p id="erro_cupom" style="display: none;">
                                    <b class="text-success text-uppercase">Cupom Inválido!</b><br />
                                </p>

                            </div>

                        </td>
                        <!-- TOTAIS  -->
                        <td class="text-lg-right px-3 table-coluna">
                            <h2 class="d-block d-lg-none mt-4 border-top">Totais</h2>
                            <p class="text-uppercase">Total em produtos: <br>
                                <input type="hidden" id="total_carrinho" value="<?php echo number_format($carrinho['subtotal'], 2, ',', '.'); ?>" />
                                <input type="hidden" id="total_desconto" value="<?php echo number_format($carrinho['desconto'], 2, ',', '.'); ?>" />
                                <b id="total_carrinho_s">R$ <?php echo number_format($carrinho['subtotal'], 2, ',', '.'); ?></b>
                            </p>
                            <p class="text-uppercase">Desconto: <br><b id="desconto_carrinho">R$ <?php echo number_format($carrinho['desconto'], 2, ',', '.'); ?> </b></p>
                            <div class="clearfix"></div>
                            <br />
                            <p class="text-uppercase">Total + Frete: <br><b id="totalefrete">Selecione o frete</b></p>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
    <div class="row px-4">
        <div class="col-12 my-4 row mx-0 d-flex justify-content-between mx-0 px-2 px-md-0">
            <div class="themesflat-button bg-accent has-shadow col-md-5 col-lg-4  text-center text-light p-0 m-2">
                <a class="w-100" href="<?php echo base_url('/'); ?>" style="padding: 5% 25%;">Continuar Comprando</a>
            </div>
            <div class="themesflat-button bg-accent has-shadow col-md-5 col-lg-4  text-center text-light p-0 m-2">
                <?php if (session()->has('cliente_id')) : ?>
                    <a class="w-100" id="validacarrinhopagamento" style="padding: 5% 25%;">Finalizar Compra</a>
                    <a class="w-100" id="link_pagamento" href="<?php echo base_url('pagamento'); ?>" style="padding: 5% 25%; display: none;">Finalizar Compra</a>
                <?php else: ?>
                    <a class="w-100" href="<?php echo base_url('login'); ?>" style="padding: 5% 25%;">Finalizar Compra</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<div class="modal fade modal-form" id="modal-endereco-alternativo" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <p class="h5">Informar outro endereço</p>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form action="<?php echo base_url('/atualizafrete'); ?>" method="post" class="form-prevent" id="formFreteCarrinho">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="text" id="carrinho_cep" name="cep" class="form-control cep-mask " placeholder="CEP*" value="" required>
                                    <button type="button" id="buscacep_carrinho" class="btn btn-secondary my-3 w-50">Consultar</button>
                                    <span style="display: none; color: red;">Campo Obrigatório</span>
                                </div>
                                <div class="form-group">
                                    <select id="carrinho_estado_id" name="estado_id" class="form-control" required>
                                        <option>Selecione um estado</option>
                                        <?php foreach ($estado as $uf) : ?>
                                            <option value="<?php echo $uf['id']; ?>" data-uf="<?php echo $uf['uf']; ?>"><?php echo $uf['nome']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span style="display: none; color: red;">Campo Obrigatório</span>
                                </div>
                                <div class="form-group">
                                    <select id="carrinho_cidade_id" name="cidade_id" class="form-control uf-select" required>
                                        <option value="">Selecione um estado</option>
                                    </select>
                                    <span style="display: none; color: red;">Campo Obrigatório</span>
                                </div>
                                <div class="form-group">
                                    <input type="text" id="carrinho_endereco" name="endereco" class="form-control " placeholder="Endereço*" value="" required>
                                    <span style="display: none; color: red;">Campo Obrigatório</span>
                                </div>
                                <div class="form-group">
                                    <input type="text" id="carrinho_bairro" name="bairro" class="form-control " placeholder="Bairro*" value="" required>
                                    <span style="display: none; color: red;">Campo Obrigatório</span>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="numero" class="form-control " placeholder="Número*" value="" required>
                                    <span style="display: none; color: red;">Campo Obrigatório</span>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="complemento" class="form-control " placeholder="Complemento (opcional)" value="">
                                </div>
                                <div class="form-group ">
                                    <div class="g-recaptcha " data-sitekey="6Lcco1MdAAAAADUw9q2lR1VkIF3olfLv2cPMCr4I" style="margin-bottom: 20px;"></div>
                                    <span style="display: none; color: red;  padding-left: 15px; ">Preencha o captcha!</span>
                                </div>
                                <button type="button" id="validaCarrinho" class="btn btn-secondary rounded-0 pull-right">Salvar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>