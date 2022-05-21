<?php echo $this->extend('admin'); ?>
<?php echo $this->section('content'); ?>
<span data-active="topicos"></span>
<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header">topicos</h2>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('admin/dashboard') ?>">Home</a></li>
            <li><a href="<?php echo base_url('admin/topicos') ?>">Tópicos</a></li>
            <li class="active">Cadastrar</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <br/><br/>
        <form enctype="multipart/form-data" action="<?php echo base_url('admin/topicos/save'); ?>" method="post">
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
                        <label>Icone</label>
                        <input type="text" name="icone" class="form-control" value="<?php echo $result['icone'] ?? set_value('icone') ?>"/>
                        <span class="text-danger"><?php echo isset($validation) ? display_errors($validation, 'icone') : ''; ?></span>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                        <label>Título</label> 
                        <input type="text" name="titulo" class="form-control" value="<?php echo $result['titulo'] ?? set_value('titulo') ?>"/>
                        <span class="text-danger"><?php echo isset($validation) ? display_errors($validation, 'titulo') : ''; ?></span>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                        <label>Link</label> 
                        <input type="text" name="link" class="form-control" value="<?php echo $result['link'] ?? set_value('link') ?>"/>
                        <span class="text-danger"><?php echo isset($validation) ? display_errors($validation, 'link') : ''; ?></span>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group">
                        <label>Texto</label> 
                        <textarea  name="texto" class="summernote"><?php echo $result['texto'] ?? set_value('texto') ?></textarea>
                        <span class="text-danger"><?php echo isset($validation) ? display_errors($validation, 'texto') : ''; ?></span>
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
