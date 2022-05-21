<?php echo $this->extend('admin'); ?>
<?php echo $this->section('content'); ?>
<span data-active="cupons"></span>
<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header">Cupons de desconta</h2>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('admin/dashboard') ?>">Home</a></li>
            <li class="active">Cadastrar</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <a href="javascript:window.history.go(-1);">
            <button class="btn btn-xs btn-default"> <i class="icon-hand-left"></i>voltar</button> 
        </a>
        <br/><br/>
        <form enctype="multipart/form-data" action="<?php echo base_url('admin/cupom/save'); ?>" method="post">
            <input type="hidden" name="id" class="form-control" value="<?php echo $result['id'] ?? set_value('id') ?>"/>
            <div class="row">
                <div class="col-xs-12 col-sm-12">
                    <div class="form-group">
                        <label>Site</label>
                        <select name="site_id" class="form-control">
                            <option value="0">Selecione um site</option>
                            <?php foreach ($sites as $site) : ?>
                                <option value="<?php echo $site['id']; ?>" <?php echo ($result['site_id'] ?? set_value('site_id')) == $site['id'] ? 'selected' : '' ?>><?php echo $site['slug']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="text-danger"><?php echo isset($validation) ? form_validation($validation, 'site_id') : ''; ?></span>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" name="nome" class="form-control" value="<?php echo $result['nome'] ?? set_value('nome') ?>"/>
                        <span class="text-danger"><?php echo isset($validation) ? form_validation($validation, 'nome') : ''; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Codigo</label>
                        <input type="text" name="codigo" class="form-control" value="<?php echo $result['codigo'] ?? set_value('codigo') ?>"/>
                        <span class="text-danger"><?php echo isset($validation) ? form_validation($validation, 'codigo') : ''; ?></span>
                    </div>

                    <div class="form-group">
                        <label>Tipo</label>
                        <select name="tipo" class="form-control">
                            <option value="1" <?php echo ($result['tipo'] ?? set_value('ativo')) == 1 ? 'selected' : '' ?>>% - desconto em Porcentagem</option>
                            <option value="2" <?php echo ($result['tipo'] ?? set_value('ativo')) == 0 ? 'selected' : '' ?>>R$ - desconto em Reais</option>
                            <span class="text-danger"><?php echo isset($validation) ? form_validation($validation, 'tipo') : ''; ?></span>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Valor do Desconto</label>
                        <input type="text" name="valor" class="form-control moeda_real" value="<?php echo $result['valor'] ?? set_value('valor') ?>"/>
                        <span class="text-danger"><?php echo isset($validation) ? form_validation($validation, 'valor') : ''; ?></span>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                        <label>Data Início</label>
                        <input type="text" name="data_inicio" class="form-control data_completa" value="<?php echo $result['data_inicio'] ?? set_value('data_inicio') ?>" />
                        <span class="text-danger"><?php echo isset($validation) ? form_validation($validation, 'data_inicio') : ''; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Data Fim</label>
                        <input type="text" name="data_fim" class="form-control data_completa" value="<?php echo $result['data_fim'] ?? set_value('data_fim') ?>" />
                        <span class="text-danger"><?php echo isset($validation) ? form_validation($validation, 'data_fim') : ''; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Ativo</label>
                        <select name="ativo" class="form-control">
                            <option value="1" <?php echo ($result['ativo'] ?? set_value('ativo')) == 1 ? 'selected' : '' ?>>Sim</option>
                            <option value="0" <?php echo ($result['ativo'] ?? set_value('ativo')) == 0 ? 'selected' : '' ?>>Não</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group">
                        <input type="submit" value="Salvar"  class="btn btn-success"/>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php echo $this->endSection(); ?>
