<?php echo $this->extend('admin'); ?>
<?php echo $this->section('content'); ?>
<span data-active="duvidas"></span>
<span data-active="duvidas"></span>
<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header">Dúvidas Frequentes</h2>
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
        <form enctype="multipart/form-data" action="<?php echo base_url('admin/duvidas/save'); ?>" method="post">
            <input type="hidden" name="id" class="form-control" value="<?php echo $result['id'] ?? set_value('id') ?>"/>
            <div class="row">
                <div class="col-xs-12 col-sm-12">
                    <div class="form-group">
                        <label>Site</label>
                        <select name="site_id" class="form-control">
                            <option>Selecione um site</option>
                            <?php foreach ($sites as $site) : ?>
                                <option value="<?php echo $site['id']; ?>" <?php echo ($result['site_id'] ?? set_value('site_id')) == $site['id'] ? 'selected' : '' ?>><?php echo $site['slug']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="text-danger"><?php echo isset($validation) ? display_errors($validation, 'site_id') : ''; ?></span>

                    </div>
                </div>
                <div class="col-xs-12 col-sm-12">
                    <div class="form-group">
                        <label>Dúvida</label>
                        <input type="text" name="duvida" class="form-control" value="<?php echo $result['duvida'] ?? set_value('duvida') ?>"/>
                        <span class="text-danger"><?php echo isset($validation) ? display_errors($validation, 'duvida') : ''; ?></span>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group">
                        <label>Resposta</label> 
                        <textarea class="form-control" rows="3" name="resposta"><?php echo $result['resposta'] ?? set_value('resposta') ?></textarea>
                        <span class="text-danger"><?php echo isset($validation) ? display_errors($validation, 'resposta') : ''; ?></span>
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
