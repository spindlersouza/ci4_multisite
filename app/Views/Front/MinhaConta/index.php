<?php echo $this->extend('front'); ?>
<?php echo $this->section('content'); ?>

<!-- conteúdo -->
<style>
    .login-tela span,
    .login-tela a,
    .login-tela dt,
    .login-tela p,
    .login-tela input[type=text],
    .login-tela input[type=email],
    .login-tela input[type=password],
    .login-tela select,
    .login-tela button {
        font-size: 14px;
    }
</style>
<section class="py-5 border-top slider-banner">
    <div class="login-tela">
        <div class="row mx-3">
            <div class="col-12 col-md-6">
                <h2 class="text-uppercase mb-3">Meu Perfil</h2>
                <dl class="dl-horizontal">
                    <dt class="border-top">Nome: <b><?php echo $cliente['nome']; ?></b></dt>
                    <dt class="border-top">CPF: <b><?php echo $cliente['cpf']; ?></b></dt>
                    <dt class="border-top">E-mail: <b><?php echo $cliente['email']; ?></b></dt>
                    <dt class="border-top">Nascimento: <b><?php echo implode('/', array_reverse(explode('-', $cliente['data_nascimento']))); ?></b></dt>
                    <dt class="border-top">Telefone: <b><?php echo $cliente['telefone']; ?></b></dt>
                    <dt class="border-top">Celular: <b><?php echo $cliente['celular']; ?></b></dt>
                    <dt class="border-top">CEP: <b><?php echo $cliente['cep']; ?></b></dt>
                    <dt class="border-top">Endereço: <b><?php echo $cliente['endereco'] . ' ' . $cliente['numero']; ?></b></dt>
                    <dt class="border-top">Complemento: <b><?php echo $cliente['complemento']; ?></b></dt>
                    <dt class="border-top">Bairro: <b>Bairro <?php echo $cliente['bairro']; ?></b></dt>
                    <dt class="border-top">Cidade: <b><?php echo $cliente['cidade']; ?> - <?php echo $cliente['estado']; ?></b></dt>
                </dl>
            </div>
            <div class="col-12 col-md-6 bg-minha-conta">
                <h2 class="text-uppercase mb-3">Painel de controle</h2>
                <a href="<?php echo base_url('meus-pedidos'); ?>" class="btn btn-secondary my-2 text-uppercase " style="width: 370px; border-radius: 5px;" >Meus Pedidos</a>
                <br />
                <a class="open-modal btn btn-secondary my-2 text-uppercase " data-toggle="modal" data-target="#modal-cadastro" href="#" style="width: 370px; border-radius: 5px;" >Alterar informações</a>
                <br />
                <a href="<?php echo base_url('/logout'); ?>" class="btn btn-secondary my-2 text-uppercase " style="width: 370px; border-radius: 5px;" >Sair</a>
            </div>
        </div>
    </div>
</section>

<!-- modal  -->
<div class="modal fade modal-form" id="modal-cadastro" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content login-tela">
            <div class="modal-header">
                <p class="h5">Alterar cadastro</p>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form action="" enctype="multipart/form-data" method="post" class="form-prevent form-insert" id="formConta">
                        <input type="hidden" name="id" value="<?php echo $cliente['id']; ?>" />
                        <div class="row">
                            <div class="col-12 col-sm-12">
                                <div class="form-group">
                                    <input type="text" name="nome" class="form-control" placeholder="Nome*" value="<?php echo $cliente['nome']; ?>" required>
                                    <span style="display: none; color: red;">Campo Obrigatório</span>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <input type="text" name="cpf" class="form-control cpf-mask" placeholder="CPF*" value="<?php echo $cliente['cpf']; ?>" required>
                                    <span style="display: none; color: red;">Campo Obrigatório</span>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <input type="text" name="data_nascimento" class="form-control data-mask" placeholder="Nascimento (dd/mm/aaaa)*" value="<?php echo implode('/', array_reverse(explode('-', $cliente['data_nascimento']))); ?>" required>
                                    <span style="display: none; color: red;">Campo Obrigatório</span>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <input type="tel" name="telefone" class="form-control fone-mask" placeholder="Telefone Contato*" value="<?php echo $cliente['telefone']; ?>">
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <input type="tel" name="celular" class="form-control fone-mask" placeholder="Telefone Celular" value="<?php echo $cliente['celular']; ?>">
                                    <span style="display: none; color: red;">Campo Obrigatório</span>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <input type="text" id="conta_cep" name="cep" class="form-control cep-mask" placeholder="CEP*" value="<?php echo $cliente['cep']; ?>" required>
                                    <span style="display: none; color: red;">Campo Obrigatório</span>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <button type="button" class="btn btn-secondary my-2 text-uppercase " id="buscacep_minhaconta">Consultar</button>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <select id="conta_estado_id" name="estado_id" class="form-control" >
                                        <option>Selecione um estado</option>
                                        <?php foreach ($estado as $uf) : ?>
                                            <option style="border: none;" value="<?php echo $uf['id']; ?>" data-uf="<?php echo $uf['uf']; ?>" <?php echo ($cliente['estado_id'] == $uf['id']) ? 'selected' : ''; ?>><?php echo $uf['nome']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span style="display: none; color: red;" id="erro_estado_id">Campo Obrigatório</span>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <select id="conta_cidade_id" name="cidade_id" class="form-control" required>
                                        <option>Selecione uma cidade</option>
                                        <?php foreach ($cidade as $city) : ?>
                                            <option style="border: none;" value="<?php echo $city['id']; ?>" <?php echo ($cliente['cidade_id'] == $city['id']) ? 'selected' : ''; ?>><?php echo $city['nome']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span style="display: none; color: red;" id="erro_estado_id">Campo Obrigatório</span>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <input type="text" id="conta_bairro" name="bairro" class="form-control" placeholder="Bairro*" value="<?php echo $cliente['bairro']; ?>" required>
                                    <span style="display: none; color: red;" id="erro_estado_id">Campo Obrigatório</span>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <input type="text" id="conta_endereco" name="endereco" data-id-endereco="2" class="form-control" placeholder="Endereço*" value="<?php echo $cliente['endereco']; ?>" required>
                                    <span style="display: none; color: red;" id="erro_estado_id">Campo Obrigatório</span>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <input type="text" name="numero" data-id-numero="2" class="form-control" placeholder="Número*" value="<?php echo $cliente['numero']; ?>" required>
                                    <span style="display: none; color: red;" id="erro_estado_id">Campo Obrigatório</span>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <input type="text" name="complemento" class="form-control" placeholder="Complemento (opcional)" value="<?php echo $cliente['complemento']; ?>">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control" placeholder="E-mail (login)*" value="<?php echo $cliente['email']; ?>" required>
                                    <span style="display: none; color: red;" id="erro_estado_id">Campo Obrigatório</span>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <input type="password" name="senha" class="form-control" placeholder="Senha">
                                    <span style="display: none; color: red;" id="erro_estado_id">Campo Obrigatório</span>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <input type="password" name="csenha" class="form-control" placeholder="Confirmar Senha">
                                    <span style="display: none; color: red;" id="erro_estado_id">Campo Obrigatório</span>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group ">
                                    <div class="g-recaptcha " data-sitekey="6Lcco1MdAAAAADUw9q2lR1VkIF3olfLv2cPMCr4I" style="margin-bottom: 20px;"></div>
                                    <span style="display: none; color: red;  padding-left: 15px; ">Preencha o captcha!</span>
                                </div>
                            </div>

                            <div class="col-12">
                                <button type="button" id="validaConta" class="btn btn-secondary rounded-0 pull-right">Alterar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <br /><br />
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>