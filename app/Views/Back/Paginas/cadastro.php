<?php echo $this->extend('admin'); ?>
<?php echo $this->section('content'); ?>
<?php // dd($result); ?>
<span data-active="politicas"></span>
<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header"><?php echo $labelPagina . ' - ' . ucfirst(SITESLUG); ?></h2>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('admin/dashboard') ?>">Home</a></li>
            <li class="active">Editar - <?php echo $labelPagina . ' - ' . ucfirst(SITESLUG); ?></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <a href="javascript:window.history.go(-1);"><button class="btn btn-xs btn-default"> <i class="icon-hand-left"></i>voltar</button> </a>
        <br/><br/>
        <form enctype="multipart/form-data" action="<?php echo base_url('admin/paginas/save'); ?>" method="post">
            <input type="hidden" name="id" class="form-control" value="<?php echo $result['id'] ?? set_value('id') ?>"/>
            <input type="hidden" name="site_id" class="form-control" value="<?php echo $result['site_id'] ?? set_value('site_id') ?>"/>
            <input type="hidden" name="slug" class="form-control" value="<?php echo $result['slug'] ?? set_value('slug') ?>"/>
            <input type="hidden" name="banner_ativo" class="form-control" value="<?php echo $result['banner_ativo'] ?? set_value('banner_ativo') ?>"/>
            <?php if ($result['banner_ativo'] == '1') : ?>
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                        <label>Banner Desktop<small>[ Dimensões: 1920x650px ]</small></label>
                        <span class="btn btn-default btn-file btn-file-lg">
                            <input type="file" name="banner">
                            <span class="text-danger"><?php echo isset($banner_dim) ? $banner_dim : ''; ?></span>
                        </span>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                        <label>Banner Mobile<small>[ Dimensões: 600x600px ]</small></label>
                        <span class="btn btn-default btn-file btn-file-lg">
                            <input type="file" name="banner_mobile">
                            <span class="text-danger"><?php echo isset($bannerMobile_dim) ? $bannerMobile_dim : ''; ?></span>
                        </span>
                    </div>
                </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-xs-12 col-sm-12">
                    <div class="form-group">
                        <label>Texto</label> 
                        <textarea  name="texto" class="summernote"><?php echo $result['texto'] ?? set_value('texto') ?></textarea>
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
