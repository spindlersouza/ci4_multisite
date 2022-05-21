<?php echo $this->extend('front'); ?>
<?php echo $this->section('content'); ?>

<!-- conteúdo  -->

<style>
    .add_carrinho {
        position: fixed;
        top: 250px;
        background: #70b1cf;
        padding: 20px;
        z-index: 9999;
        width: 380px;
        left: 40vw;
        border-radius: 10px;
        text-align: center;
        box-shadow: 2px 2px 10px;
    }

    .add_carrinho a {
        position: relative;
        top: -15px;
        overflow: hidden;
        right: -177px;
        background: #dddddd47;
        border-radius: 0 10px 0 10px;
    }

    @media (max-width: 772px) {
        .add_carrinho {
            left: 10vw;
            width: 300px;
        }

        .add_carrinho a {
            top: -16px;
            overflow: hidden;
            right: -137px;
        }

    }
</style>
<div class="slider-banner border-top" style="height: 5px;"></div>
<section class="my-5">
    <div class="">
        <div class="row mx-3">
            <div class="col-12">
                <p class="border-bottom">Total em Produtos: <span class="pull-right"><b>R$ <?php echo $pagamento['subtotal']; ?></b></span></p>
                <!-- <p class="border-bottom">Desconto Cupom: <span class="pull-right"><b>R$ <?php echo $pagamento['desconto']; ?> </b></span></p> -->
                <p class="border-bottom">Frete: <span class="pull-right"><b> R$ <?php echo $pagamento['frete']; ?></b></span></p>
                <p class="border-bottom">TOTAL DA COMPRA: <span class="pull-right"><b>R$ <?php echo $pagamento['total']; ?></b></span></p>
            </div>
        </div>
        <div class="row mx-3">
            <div class="col-12 mt-5">
                <h2 class="font-700 text-uppercase">Selecione uma Forma de Pagamento:</p>
            </div>
        </div>
        <br />
        <p class="container__payment"></p>
        <p class="container__result"></p>
        <div class="row mx-3">
            <div class="col-12">
                <div class="">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item"><a class="nav-link" id="tabs1-tab" data-toggle="tab" href="#tabs1" role="tab"><i class="fa fa-credit-card"></i>&nbsp;&nbsp;Cartão de Crédito</a></li>
                        <li class="nav-item"><a class="nav-link" id="tabs2-tab" data-toggle="tab" href="#tabs2" role="tab"><i class="fa fa-barcode"></i>&nbsp;&nbsp;Boleto Bancário</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="tabs1" role="tabpanel" aria-labelledby="tabs1-tab">
                            <form id="form-checkout">
                                <input type="hidden" id="total_carrinho" value="<?php echo $pagamento['total']; ?>" />
                                <input type="text" name="cardNumber" id="form-checkout__cardNumber" />
                                <input type="text" name="cardExpirationDate" id="form-checkout__cardExpirationDate" />
                                <input type="text" name="cardholderName" id="form-checkout__cardholderName" />
                                <input type="hidden" name="cardholderEmail" id="form-checkout__cardholderEmail" value="<?php echo $cliente['email']; ?>" />
                                <input type="text" name="securityCode" id="form-checkout__securityCode" />
                                <select name="issuer" id="form-checkout__issuer"></select>
                                <div class="d-none">
                                    <select name="identificationType" id="form-checkout__identificationType"></select>
                                    <input type="text" name="identificationNumber" id="form-checkout__identificationNumber" value="<?php echo str_replace(['.', '-'], '', $cliente['cpf']); ?>" />
                                </div>
                                <select name="installments" id="form-checkout__installments"></select>

                                <div class="themesflat-button bg-accent has-shadow col-md-5 col-lg-4 text-center text-light p-0 my-4">
                                <button type="submit" id="form-checkout__submit">Pagar</button>
                                </div>


                                <progress value="0" class="progress-bar">Carregando...</progress>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="tabs2" role="tabpanel" aria-labelledby="tabs2-tab">
                            <div class="row">
                                <div class="col-12 my-4">
                                    <a href="<?php echo base_url('/api/mp/pagamentoboleto'); ?>" class="themesflat-button has-padding-36 bg-accent has-shadow">Fechar pedido e gerar o boleto</a>
                                    <div class="box-boleto"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- alerta cartão -->
        <div id="Cartao" class="add_carrinho anime-down">
            <a class="text-light p-2" href="javascript:void(0);" onclick="CartaoClose()"> <span>X</span></a>
            <h5 class="text-light"><b>Pronto! PEDIDO FINALIZADO!</b><br>
                Assim que confirmarmos o pagamento efetuaremos o envio do seu pedido!</h5>
        </div>
          <!-- alerta compra negada -->
          <div id="CompraErro" class="add_carrinho anime-down" style="background: red;">
            <a class="text-light p-2" href="javascript:void(0);" onclick="CompraErroClose()"> <span>X</span></a>
            <h5 class="text-light"><b>Pedido Negado!</b><br>Não foi possível finalizar seu pedido neste momento.</h5>
        </div>
    </div>
</section>

<!-- modelos de email de resposta  -->
<section class="border border-gray my-5">
    <!-- email compra realizada  -->
    <div style="max-width: 850px; margin: 0 10%;">
        <img src="<?php echo base_url('public/Front/assets/img/email_topo.jpg'); ?>" alt="" style="width: 100%;">
        <br>
        <br>

        <span>
            21/03/2022 - 10:24:26
        </span>
        <br>
        <br>

        <h3>Confirmação de pedido realizado - Número: #0000</h3>
        <br>
        <br>
        <br>

        <p> <b>Prezado(a) Cliente NOME DO CLIENTE,</b>
            <br>
            A compra que você realizou está sendo processada e assim que identificarmos o seu pagamento o seu pedido será separado para entrega ou para retirada na loja, caso você tenha optado.
            <br>
            <br>

            Esta mensagem é exclusiva à pessoa a quem foi destinada, podendo haver informações confidenciais e/ou legalmente protegidas. Se você não for o destinatário, é notificado que não deve fazer cópias, divulgações, verificações ou qualquer outro ato de mesma espécie, com o objetivo de utilizar estas informações. Por favor, caso tenha havido o engano, desde já, é importante que remova as informações de seus servidores e/ou banco de dados, precavendo-se assim de acarretamentos legais.
            <br>
            <br>
        </p>
        <br>
        <br>

        <p> Equipe :: Grupo Instinto Íntimo<br>
            Copyright © 2022 - TODOS OS DIREITOS RESERVADOS
        </p>
        <br>
        <img src="<?php echo base_url('public/Front/assets/img/email_rodape.jpg'); ?>" alt="" style="width: 100%;">
    </div>
</section>

<section class="border border-gray my-5">
    <!-- email cadastro novo -->
    <div style="max-width: 850px; margin: 0 10%;">
        <img src="<?php echo base_url('public/Front/assets/img/email_topo.jpg'); ?>" alt="" style="width: 100%;">
        <br>
        <br>

        <span>
            21/03/2022 - 10:24:26
        </span>
        <br>
        <br>

        <h3>Cadastro Realizado com sucesso!</h3>
        <br>
        <br>
        <br>

        <p> <b>Prezado(a) Cliente NOME DO CLIENTE,</b>
            <br>
            É uma grande satisfação ter você como nosso cliente. <br><br>
            A PARTIR DE AGORA, UTILIZE SEU E-MAIL E SUA SENHA para acessar seu PAINEL DE CONTROLE, acompanhar os seus PEDIDOS ou gerenciar o seu CADASTRO.
            <br>
            <br>
        </p>
        <br>
        <br>

        <p> Equipe :: Grupo Instinto Íntimo<br>
            Copyright © 2022 - TODOS OS DIREITOS RESERVADOS
        </p>
        <br>
        <img src="<?php echo base_url('public/Front/assets/img/email_rodape.jpg'); ?>" alt="" style="width: 100%;">
    </div>
</section>

<script>
    function BoletoClose() {
        document.getElementById("Boleto").style.display = "none";
    }

    function CartaoClose() {
        document.getElementById("Cartao").style.display = "none";
    }

    function CompraErroClose() {
        document.getElementById("CompraErro").style.display = "none";
    }
</script>


<?php echo $this->endSection(); ?>