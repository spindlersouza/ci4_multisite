<?php echo $this->extend('front'); ?>
<?php echo $this->section('content'); ?>

<!-- conteúdo  -->
<div class="slider-banner border-top" style="height: 5px;"></div>
<section class="my-5">
    <div class="">
        <div class="row mx-3">
            <div class="col-12">
                <p class="border-bottom">Total em Produtos: <span class="pull-right"><b>R$ 217,98</b></span></p>
                <p class="border-bottom">Desconto Cupom: <span class="pull-right"><b>R$ 40,00</b></span></p>
                <p class="border-bottom">Frete: <span class="pull-right"><b> R$ 25,00</b></span></p>
                <p class="border-bottom">TOTAL DA COMPRA: <span class="pull-right"><b>R$ 202,98</b></span></p>
            </div>
        </div>
        <div class="row mx-3">
            <div class="col-12 mt-5">
                <h2 class="font-700 text-uppercase">Selecione uma Forma de Pagamento:</p>
            </div>
        </div>
        <br />
        <div class="row mx-3">
            <div class="col-12">
                <div class="">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link" id="tabs1-tab" data-toggle="tab" href="#tabs1" role="tab"><i class="fa fa-credit-card"></i>&nbsp;&nbsp;Cartão de Crédito
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tabs2-tab" data-toggle="tab" href="#tabs2" role="tab"><i class="fa fa-barcode"></i>&nbsp;&nbsp;Boleto Bancário</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade" id="tabs1" role="tabpanel" aria-labelledby="tabs1-tab">
                            <form method="post" action="#" class="form-prevent">
                                <div class="row">
                                    <div class="col-12 col-sm-6 col-md-5 my-4">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="cardNumber">Número do Cartão de Crédito:</label>
                                                    <input type="text" class="form-control numero-cartao-mask" name="cardNumber" data-brand="" required />
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="creditCardHolderName">Nome (como está impresso
                                                        no
                                                        Cartão):</label>
                                                    <input type="text" class="form-control input-upper" name="creditCardHolderName" required />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-5 my-4">
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="creditCardHolderName">Válidade do Cartão (formato:
                                                    MM/AA):</label><br />
                                                <div class="form-group">
                                                    <input type="text" class="form-control mm-aa-mask" name="expiration" required />
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="cvv">Código de Segurança
                                                        <small>(CVV)</small></label>
                                                    <input type="text" class="form-control codigo-seguranca-mask" name="cvv" required />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="parcelamento-cartao"></div>
                                        <div class="row dados-cartao" style="display: none;">
                                            <div class="col-12">
                                                <br />
                                                <h5 class="">
                                                    <span class="text-uppercase">Os dados para cobrança são os
                                                        mesmos do seu cadastro?</span><br />
                                                    <small>Confira abaixo e caso necessário informe os dados
                                                        atualizados:</small>
                                                </h5>
                                            </div>
                                            <div class="col-12 dados-cartao">
                                                <div class="row">
                                                    <div class="col-12 col-sm-6 col-md-5">
                                                        <div class="form-group">
                                                            <label for="titular_cpf">CPF do Titular:</label>
                                                            <input type="text" name="creditCardHolderCPF" class="form-control cpf-mask" value="" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="titular_nascimento">Data de Nascimento
                                                                do
                                                                Titular:</label>
                                                            <input type="text" name="creditCardHolderBirthDate" class="form-control data-mask" value="" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="titular_telefone">Telefone do
                                                                Titular:</label>
                                                            <input type="tel" name="holderPhone" class="form-control fone-mask" value="" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="titular_telefone">UF de
                                                                Cobrança:</label>
                                                            <input type="tel" name="billingAddressState" class="form-control uf-mask" value="" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="titular_telefone">Cidade de
                                                                Cobrança:</label>
                                                            <input type="tel" name="billingAddressCity" class="form-control" value="" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-6 col-md-5">
                                                        <div class="form-group">
                                                            <label for="titular_cep">CEP de Cobrança:</label>
                                                            <input type="text" name="billingAddressPostalCode" data-id-cep="0" class="form-control cep-mask" value="" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="titular_endereco">Endereço de
                                                                Cobrança:</label>
                                                            <input type="text" name="billingAddressStreet" data-id-endereco="0" class="form-control" value="" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="titular_bairro">Bairro de
                                                                Cobrança:</label>
                                                            <input type="text" name="billingAddressDistrict" data-id-bairro="0" class="form-control" value="" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="titular_numero">Número de
                                                                Cobrança:</label>
                                                            <input type="text" name="billingAddressNumber" data-id-numero="0" class="form-control" value="" required>
                                                        </div>
                                                       
                                                    </div>
                                                    <div class="col-12">
                                                        <big class="totalAmount"></big>
                                                    </div>
                                                    <div class="col-12">
                                                        <br />
                                                        <input type="hidden" name="psToken" value="" />
                                                        <input type="hidden" name="psHash" value="" />
                                                        <input type="hidden" name="bandeira" value="" />
                                                        <input type="hidden" name="acao" value="pagar_ps" />
                                                        <button type="submit" class="btn btn-success btn-credit-payment">Concluir
                                                            pagamento</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="tabs2" role="tabpanel" aria-labelledby="tabs2-tab">
                            <div class="row">
                                <div class="col-12 my-4">
                                    <button class="themesflat-button has-padding-36 bg-accent has-shadow">Fechar
                                        pedido e gerar o
                                        boleto</button>
                                    <div class="box-boleto"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php echo $this->endSection(); ?>