<footer class="footer">
    <div>
        <div class="row mx-3">

            <div class="col-sm-6 col-md-3">
                <div class="widget widget-link">
                    <ul>
                        <li class="pb-4 border-bottom">
                            <i class="fa fa-weixin fa-2x"></i>&emsp;
                            <span>Atendimento Online</span>
                            <p class="text-footer">Fale pelo <b><a href="https://api.whatsapp.com/send?phone=5505499266-9406" target="_blank" style="font-weight: 500;">Whatsapp</a></b> </p>
                        </li>
                        <li class="py-4 border-bottom">
                            <i class="fa fa-send fa-2x"></i>&emsp;
                            <span>Email</span>
                            <p class="text-footer">Envie e-mail para <a href="mailto:sac@instintointimo.com.br" target="_blank" style="font-weight: 500;">sac@instintointimo.com.br</a></p>
                        </li>
                        <!-- <li class="py-4 border-bottom">
                          <a href="<?php echo base_url('lojas'); ?>">
                            <i class="fa fa-map-marker fa-2x"></i>&emsp;<span>Nossos Locais</span>
                            <p class="text-footer">Clique aqui para encontrar uma loja próxima</p>
                          </a>
                        </li> -->
                    </ul>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 border-right">
                <div class="widget widget-link link-login">
                    <h4><b>Sobre a Instinto Íntimo</b></h4><br>
                    <ul>
                        <li><a href="https://instintointimo.com.br/home" target="_blank">A Marca</a></li>
                        <!-- <li><a href="<?php echo base_url('lojas'); ?>" target="_blank">Nossas Lojas</a></li> -->
                        <li><a href="https://instintointimo.com.br/seja-colaborador" target="_blank">Trabalhe Conosco</a></li>
                        <li><a href="https://instintointimo.com.br/seja-revendedor" target="_blank">Seja um Revendedor</a></li>
                        <li><a href="https://instintointimo.com.br/seja-franqueado" target="_blank">Seja um Franqueado</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-6 col-md-3  border-right">
                <div class="widget widget-link link-faq">
                    <h4><b>Links Úteis</b></h4> <br>
                    <ul>
                        <li><a href="<?php echo base_url('politica-trocas'); ?>">Trocas e Devoluções</a></li>
                        <li><a href="<?php echo base_url('duvidas-frequentes'); ?>">Dúvidas Frequentes</a></li>
                        <li><a href="<?php echo base_url('termos-de-uso'); ?>">Termos de Uso</a></li>
                        <li><a href="<?php echo base_url('politica-privacidade'); ?>">Política de Privacidade</a></li>
                    </ul>
                </div>

            </div>
            <div class="col-sm-6 col-md-3">
                <div class="widget widget-brand">
                  <!-- <div class="logo logo-footer"><a href="/"><img src="<?php echo base_url('public/Front/assets/img/logo.png'); ?>" alt="image" width="200"></a></div>
                            <ul class="flat-contact">
                                <li class="address">
                                    Rua Teste 123<br> 
                                    Bairro Bonito<br> 
                                    São Paulo - SP<br> 
                                    CEP 90000-000<br>
                                </li>
                            </ul> -->
                    <ul class="flat-social">
                        <li><a href="https://facebook.com/vibrancefitwear" target="_blank"><i class="fa fa-facebook"></i></a></li>
                        <!-- <li><a href="#" target="_blank"><i class="fa fa-twitter"></i></a></li> -->
                        <li><a href="https://instagram.com/vibrancefitwear" target="_blank"><i class="fa fa-instagram"></i></a></li>
                        <!-- <li><a href="#" target="_blank"><i class="fa fa-linkedin"></i></a></li> -->
                    </ul>
                    <div class="">
                        <img class=" m-3" src="<?php echo base_url('public/Front/assets/img/pagamento.png'); ?>" alt="image">
                        <img class=" m-3" src="<?php echo base_url('public/Front/assets/img/site-protegido.png'); ?>" alt="image">
                    </div>
                </div>
            </div>

        </div>

    </div>
    <a href="https://api.whatsapp.com/send?phone=5505499266-9406" style="position:fixed;width:60px;height:60px;bottom:70px;right:20px;background-color:green;color:#FFF !important;border-radius:50px;text-align:center;font-size:30px; z-index:1000;" target="_blank">
        <i style="margin-top:15px" class="fa fa-whatsapp"></i>
    </a>

</footer>

<!-- Modal Sucesso-->
<div class="modal fade" id="sucessoModal" tabindex="-1" aria-labelledby="sucessoModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="margin-top: 20vh;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sucessoModalLabel">Sucesso!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-success text-white text-center">
                Cadastro realizado com sucesso!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="avaliacaoModal" tabindex="-1" aria-labelledby="avaliacaoModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="margin-top: 20vh;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sucessoModalLabel">Sucesso!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-success text-white text-center">
                Obrigado para avaliação!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Aviso-->
<div class="modal fade" id="avisoModal" tabindex="-1" aria-labelledby="avisoModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="margin-top: 20vh;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="avisoModalLabel">Erro!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-danger text-white text-center">
                Ocorreu um erro ao realizar o cadastro!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal pagamento-->
<div class="modal fade" id="pagamentoModal" tabindex="-1" aria-labelledby="pagamentoModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="margin-top: 20vh;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="avisoModalLabel">Erro!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-danger text-white text-center">
                Ocorreu um erro ao realizar o pagamento!<br />
                Por favor tente mais tarde
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal News -->
<div class="modal fade" id="avisoNewsModal" tabindex="-1" aria-labelledby="avisoNewsModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="margin-top: 20vh;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="avisoModalLabel">Erro!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-danger text-white text-center">
                Ocorreu um erro ao realizar o cadastro!
                Nome e email são obrigatórios!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="sucessoNewsModal" tabindex="-1" aria-labelledby="sucessoNewsModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="margin-top: 20vh;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sucessoModalLabel">Sucesso!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-success text-white text-center">
                Cadastro realizado com sucesso!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
