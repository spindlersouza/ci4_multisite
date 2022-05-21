<?php echo $this->extend('front'); ?>
<?php echo $this->section('content'); ?>
<?php // dd(session()->getFlashdata('error'));             ?>
<!-- conteúdo -->
<style type="text/css">
    .nav-tabs .nav-link {
        border: 1px solid #ddd;
        background-color: #cce2e9;
        margin-right: 3px;
        position: relative;
        top: -1px;
    }

    .login-tela span,
    .login-tela a,
    .login-tela p,
    .login-tela input[type=text],
    .login-tela input[type=email],
    .login-tela input[type=password],
    .login-tela select,
    .login-tela button {
        font-size: 14px;
    }

    .login_sucesso {
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

    .login_sucesso a {
        position: relative;
        top: -17px;
        overflow: hidden;
        right: -177px;
        background: #dddddd47;
        border-radius: 0 10px 0 10px;
    }

    @media (max-width: 772px) {
        .login_sucesso {
            left: 10vw;
            width: 300px;
        }

        .login_sucesso a {
            top: -16px;
            overflow: hidden;
            right: -137px;
        }

    }
</style>
<section class="py-5 border-top slider-banner">
    <div class="">
        <div class="row mx-3">
            <div class="col-12">
                <ul class="nav nav-tabs" role="tablist" id="pills-tab1">
                    <li class="nav-item mt-1 text-center" style="width: 250px;"><a class="nav-link active" id="tab1-aba" data-toggle="tab" href="#tab1" role="tab">Já sou cadastrado</a></li>
                    <li class="nav-item mt-1 text-center" style="width: 250px;"><a class="nav-link" id="tab2-aba" data-toggle="tab" href="#tab2" role="tab">Ainda não sou cadastrado</a></li>
                </ul>
                <div class="tab-content login-tela">
                    <div class="tab-pane show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
                        <div class="col-12 px-0">
                            <p class="font-700 my-3"><b>Entre com os seus dados cadastrados abaixo:</b></p>
                            <form action="" method="post" class="form-prevent form-signin">
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <div class="input-group">                                              
                                                <span class="input-group-addon " id="label-user"><i class="fa fa-user"></i></span>
                                                <input type="text" name="email" class="form-control " placeholder="E-mail" style="border-radius: 0 5px 5px 0;" />
                                            </div>
                                            <span class="text-danger"><?php echo isset(session()->getFlashdata('error')['email']) ? session()->getFlashdata('error')['email'] : ''; ?></span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon " id="label-pass"><i class="fa fa-key"></i></span>
                                                <input type="password" name="senha" class="form-control " placeholder="Senha" style="border-radius: 0 5px 5px 0;" />
                                            </div>
                                            <span class="text-danger"><?php echo isset(session()->getFlashdata('error')['senha']) ? session()->getFlashdata('error')['senha'] : ''; ?></span>
                                            <span class="text-danger"><?php echo (session()->getFlashdata('erroLogin') != '') ? session()->getFlashdata('erroLogin') : ''; ?></span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <input type="hidden" name="acao" value="login" />
                                        <button type="submit" class="btn btn-secondary w-100 " style="padding: 12px;">Login</button>
                                    </div>
                                </div>
                            </form>
                            <br />

                            <div class="form-pass display-none" data-toggle-target="pass">
                                <div class="form-prevent form-signin row">
                                    <div class="col-12 col-md-4"></div>
                                    <div class="col-12 col-md-4 form-group m-0">
                                        <p><b>Esqueceu sua senha?</b>  </p>
                                        <div class="input-group">
                                            <span class="input-group-addon" id="label-user"><i class="fa fa-unlock"></i></span>
                                            <input type="email" name="email" class="form-control" placeholder="E-mail cadastrado" required style="border-radius: 0 5px 5px 0;">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <p>&nbsp;</p>
                                        <input type="hidden" name="acao" value="pass" />
                                        <button type="button" class="btn btn-secondary w-100" style="padding: 12px;">Enviar</button>
                                    </div>
                                </div>
                            </div>

                            <!-- alerta adicionado ao carrinho -->
                            <div id="LoginSucess" style="display:none;" class="login_sucesso anime-down">
                                <a class="text-light p-2" href="javascript:void(0);" onclick="LoginSucessClose()"> <span>X</span></a>
                                <h5 class="text-light">Login realizado com sucesso!</h5>
                            </div>

                        </div>
                    </div>

                    <div class="tab-pane  row" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                        <div class="col-12">
                            <p class="font-700 my-3"><b>Informe seu dados abaixo para se cadastrar:</b></p>
                            <form action="#" enctype="multipart/form-data" method="post" id="formCadastro" class="form-prevent form-insert">
                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <input type="text" id="cadastro_nome" name="nome" class="form-control" placeholder="Nome*" value="<?php echo set_value('nome'); ?>" required>
                                            <span style="display: none; color: red;" id="erro_nome">Campo Obrigatório</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6"></div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <input type="text" id="cadastro_cpf" name="cpf" class="form-control cpf-mask" placeholder="CPF*" value="<?php echo set_value('cpf'); ?>" required>
                                            <span style="display: none; color: red;" id="erro_cpf">Campo Obrigatório</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <input type="text" id="cadastro_data_nascimento" name="data_nascimento" class="form-control data-mask" placeholder="Nascimento (dd/mm/aaaa)*" value="<?php echo set_value('data_nascimento'); ?>" required>
                                            <span style="display: none; color: red;" id="erro_data_nascimento">Campo Obrigatório</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <input type="text" id="cadastro_celular" name="celular" class="form-control fone-mask" placeholder="Celular*" value="<?php echo set_value('celular'); ?>" required>
                                            <span style="display: none; color: red;" id="erro_celular">Campo Obrigatório</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <input type="text" name="telefone" class="form-control fone-mask" value="<?php echo set_value('telefone'); ?>" placeholder="Telefone">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <input type="text" id="cadastro_cep" name="cep" class="form-control cep-mask" value="<?php echo set_value('cep'); ?>" placeholder="CEP*" required>
                                            <span style="display: none; color: red;" id="erro_celular">Campo Obrigatório</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <button type="button" id="buscacep_cadastro" class="btn btn-secondary form-control w-100 mb-3" valu style="height: 50px;">Consultar</button>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <select id="cadastro_estado_id" name="estado_id" class="form-control" style="height: 50px; border: 1px solid #ebebeb;">
                                                <option>Selecione um estado</option>
                                                <?php foreach ($estados as $uf) : ?>
                                                    <option style="border: none;" value="<?php echo $uf['id']; ?>" data-uf="<?php echo $uf['uf']; ?>"><?php echo $uf['nome']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <span style="display: none; color: red;" id="erro_estado_id">Campo Obrigatório</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <select id="cadastro_cidade_id" name="cidade_id" class="form-control" style="height: 50px; border: 1px solid #ebebeb;">
                                                <option>Selecione um estado</option>
                                            </select>
                                            <span style="display: none; color: red;" id="erro_cidade_id">Campo Obrigatório</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <input type="text" id="cadastro_endereco" name="endereco" class="form-control" value=" <?php echo set_value('endereco'); ?>" placeholder="Endereço*" required>
                                            <span style="display: none; color: red;" id="erro_endereco">Campo Obrigatório</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <input type="text" id="cadastro_bairro" name="bairro" class="form-control" value="<?php echo set_value('bairro'); ?>" placeholder="Bairro*" required>
                                            <span style="display: none; color: red;" id="erro_bairro">Campo Obrigatório</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <input type="text" id="cadastro_numero" name="numero" class="form-control" value="<?php echo set_value('numero'); ?>" placeholder="Número*" required>
                                            <span style="display: none; color: red;" id="erro_complemento">Campo Obrigatório</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <input type="text" id="cadastro_complemento" name="complemento" class="form-control" value="<?php echo set_value('complemento'); ?>" placeholder="Complemento (opcional)">
                                            <span style="display: none; color: red;" id="erro_complemento">Campo Obrigatório</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <input type="text" id="cadastro_email" name="email" class="form-control" placeholder="E-mail (login)*" value="<?php echo set_value('email'); ?>" data-required="email" required>
                                            <span style="display: none; color: red;" id="erro_email">Campo Obrigatório</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6"></div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <input type="password" id="conta_senha" name="senha" class="form-control" value="<?php echo set_value('senha'); ?>" placeholder="Senha*" required>
                                            <span style="display: none; color: red;" id="erro_senha">Campo Obrigatório</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <input type="password" id="conta_csenha" name="csenha" class="form-control" value="<?php echo set_value('csenha'); ?>" placeholder="Confirme a Senha*" data-    required="passwd" required>
                                            <span style="display: none; color: red;" id="erro_csenha">Campo Obrigatório</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group ">
                                            <div class="g-recaptcha " data-sitekey="6Lcco1MdAAAAADUw9q2lR1VkIF3olfLv2cPMCr4I" style="margin-bottom: 20px;"></div>
                                            <span style="display: none; color: red;  padding-left: 15px; ">Preencha o captcha!</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <button type="button" id="validaCadastro" class="w-100 btn btn-secondary" style="height: 50px;">Cadastrar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    function LoginSucessClose() {
        document.getElementById("LoginSucess").style.display = "none";
    }
</script>
<?php echo $this->endSection(); ?>