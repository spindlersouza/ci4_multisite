<?php echo $this->extend('admin'); ?>
<?php echo $this->section('content'); ?>
<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header">Configurações</h2>
        <ol class="breadcrumb">
            <li><a href="/admin">Home</a></li>
            <li><a href="/admin/config">Configurações</a></li>
            <li class="active"><?php echo strtoupper(SITESLUG); ?></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <form enctype="multipart/form-data" action="<?php echo base_url('admin/config/save'); ?>" method="post">
            <input type="hidden" name="id" value="<?php echo $result['id']; ?>" />
            <input type="hidden" name="site_id" value="<?php echo SITEENABLED; ?>" />
            <input type="hidden" name="created_usuario_id" value="<?php echo session('admin_usuario_id'); ?>" />
            <div class="row">
                <div class="form-group col-sm-6">
                    <label>CEP Remetente</label>
                    <input type="text" name="cep_remetente" class="form-control cep-mask" value="<?php echo $result['cep_remetente']; ?>"/>
                </div>
            </div>
            <hr />
            <div class="row">
                <div class="form-group col-sm-6">
                    <label>Correios - Usuário</label>
                    <input type="text" name="correios_usuario" class="form-control" value="<?php echo $result['correios_usuario']; ?>" />   
                </div>
                <div class="form-group col-sm-6">
                    <label>Correios - Senha</label>
                    <input type="text" name="correios_senha" class="form-control" value="<?php echo $result['correios_senha']; ?>" />
                </div>
            </div>
            <hr />
            <div class="row">
                <div class="form-group col-sm-6 offset-sm-6">
                    <label>Pagseguro - Ambiente</label>
                    <select name="pagseguro_ambiente" class="form-control" >
                        <option value="p" <?php echo $result['pagseguro_ambiente'] == 'p' ? 'selected' : ''; ?>>Produção</option>
                        <option value="s" <?php echo $result['pagseguro_ambiente'] == 's' ? 'selected' : ''; ?>>Sandbox</option>
                    </select>
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-sm-6">
                    <label>Pagseguro - E-mail</label>
                    <input type="text" name="pagseguro_email" class="form-control" value="<?php echo $result['pagseguro_email']; ?>" />
                </div>
                <div class="form-group col-sm-6">
                    <label>Pagseguro - Token</label>
                    <input type="text" name="pagseguro_token" class="form-control" value="<?php echo $result['pagseguro_token']; ?>" />
                </div>
            </div>
            <hr />
            <div class="row">
                <div class="form-group col-sm-6">
                    <label>Frenet - Token</label>
                    <input type="text" name="frenet_token" class="form-control" value="<?php echo $result['frenet_token']; ?>" />
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-sm-6">
                    <label>Frenet - Chave</label>
                    <input type="text" name="frenet_chave" class="form-control" value="<?php echo $result['frenet_chave']; ?>" />
                </div>
                <div class="form-group col-sm-6">
                    <label>Frenet - Senha</label>
                    <input type="text" name="frenet_senha" class="form-control" value="<?php echo $result['frenet_senha']; ?>" />
                </div>
            </div>
            <hr />
            <div class="row">
                <div class="form-group col-sm-6">
                    <label>E-mail de Autenticação (PHP Mailer)</label>
                    <input type="text" name="email_usuario" class="form-control" value="<?php echo $result['email_usuario']; ?>" />
                </div>
                <div class="form-group col-sm-6">
                    <label>Senha do E-mail de Autenticação (PHP Mailer)</label>
                    <input type="text" name="email_senha" class="form-control" value="<?php echo $result['email_senha']; ?>" />
                </div>
                <div class="form-group col-sm-6">
                    <label>Servidor SMTP</label>
                    <input type="text" name="email_smtp" class="form-control" value="<?php echo $result['email_smtp']; ?>" />
                </div>
                <div class="form-group col-sm-6">
                    <label>Servidor SMTP - Porta</label>
                    <input type="text" name="email_smtp_porta" class="form-control" value="<?php echo $result['email_smtp_porta']; ?>" />
                </div>
                <div class="form-group col-sm-4">
                    <label>E-mail Notificação</label>
                    <input type="text" name="email_notificacao" class="form-control" value="<?php echo $result['email_notificacao']; ?>" />
                </div>
                <div class="form-group col-sm-4">
                    <label>E-mail Notificação (cópia)</label>
                    <input type="text" name="email_notificacao_copia" class="form-control" value="<?php echo $result['email_notificacao_copia']; ?>"/>
                </div>
                <div class="form-group col-sm-4">
                    <label>E-mail Notificação (cópia oculta)</label>
                    <input type="text" name="email_notificacao_copia_oculta" class="form-control" value="<?php echo $result['email_notificacao_copia_oculta']; ?>"/>
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-sm-6">
                    <label>Imagem do cabeçalho do E-mail de Notificação <small>(dimensões: 850x280px)</small></label>
                    <?php if (!empty($result['email_cabecalho'])) { ?>
                        <a href="<?php echo base_url('public/upload/configs/' . $result['email_cabecalho']); ?>" class="fancybox btn btn-default"><i class="fa fa-picture-o roxo"></i></a>
                    <?php } ?>
                    <span class="btn btn-default btn-file btn-file-lg">
                        <input type="file" name="email_cabecalho">
                    </span>
                </div>
                <div class="form-group col-sm-6">
                    <label>Imagem do rodapé do E-mail de Notificação <small>(dimensões: 850x90px)</small></label>
                    <?php if (!empty($result['email_rodape'])) { ?>
                        <a href="<?php echo base_url('public/upload/configs/' . $result['email_rodape']); ?>" class="fancybox btn btn-default"><i class="fa fa-picture-o roxo"></i></a>
                    <?php } ?>
                    <span class="btn btn-default btn-file btn-file-lg"><input type="file" name="email_rodape"></span>
                </div>
                <div class="form-group col-sm-12">
                    <label>Mensagem de Notificação para Novos Cadastros</label> 
                    <textarea class="form-control summernote" rows="7" name="texto_cadastro"><?php echo $result['texto_cadastro']; ?></textarea>
                </div>

                <div class="form-group col-sm-12">
                    <label>Mensagem de Notificação para Novos Pedidos</label> 
                    <textarea class="form-control summernote" rows="7" name="texto_pedido"><?php echo $result['texto_pedido']; ?></textarea>
                </div>
            </div>
            <div class="row"><div class="form-group"><input type="submit" value="Salvar"  class="btn btn-info"/></div></div>
        </form>
    </div>
</div>
<?php echo $this->endSection(); ?>

