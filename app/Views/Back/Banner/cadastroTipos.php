<?php echo $this->extend('admin'); ?>
<?php echo $this->section('content'); ?>
<span data-active="banners"></span>

<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header">Banner <small>/cadastro</small>
        </h2>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('admin/dashboard'); ?>">Home</a></li>
            <li><a href="<?php echo base_url('admin/banner/indexTipos/' . ($result['tipo_id'] ?? $tipo_id) ?? set_value('tipo_id')); ?>">Banner</a></li>
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
        <form enctype="multipart/form-data" action="<?php echo base_url('admin/banner/saveTipos'); ?>" method="post">
            <input type="hidden" name="id" class="form-control" value="<?php echo $result['id'] ?? set_value('id') ?>"/>
            <input type="hidden" name="tipo_id" class="form-control" value="<?php echo ($result['tipo_id'] ?? $tipo_id) ?? set_value('tipo_id') ?>"/>
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group col-sm-6">
                        <label>Nome</label>
                        <input type="text" name="nome" class="form-control" value="<?php echo $result['nome'] ?? set_value('nome') ?>"/>
                        <span class="text-danger"><?php echo isset($validation) ? form_errors($validation, 'nome') : ''; ?></span>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Link</label>
                        <input type="text" name="link" class="form-control" value="<?php echo $result['link'] ?? set_value('link') ?>"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group col-sm-6">
                        <label>Data Início</label>
                        <input type="text" name="data_inicio" class="form-control data_completa" value="<?php echo $result['data_inicio'] ?? set_value('data_inicio') ?>"/>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Data Fim</label>
                        <input type="text" name="data_fim" class="form-control data_completa" value="<?php echo $result['data_fim'] ?? set_value('data_fim') ?>"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group col-sm-6">
                        <label>Imagem Desktop<small>[ Dimensões: <?php echo (($result['tipo_id'] ?? '0') == '4' || $tipo_id == '4' || set_value('tipo_id') == '4') ? '950x700px' : '1920x650px'; ?> ]</small></label>
                        <a href="<?php echo base_url('public/upload/banner/'. $result['banner']); ?>" class="fancybox btn btn-default"><i class="fa fa-picture-o roxo"></i></a>
                        <span class="btn btn-default btn-file btn-file-lg">
                            <input type="file" name="banner">
                            <span class="text-danger">
                                <?php echo isset($validation) ? form_errors($validation, 'banner') : ''; ?>
                                <?php echo isset($banner_dim) ? $banner_dim : ''; ?>
                            </span>
                        </span>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Imagem Mobile<small>[ Dimensões: 600x600px ]</small></label>
                        <a href="<?php echo base_url('public/upload/banner/'. $result['banner_mobile']); ?>" class="fancybox btn btn-default"><i class="fa fa-picture-o roxo"></i></a>
                        <span class="btn btn-default btn-file btn-file-lg">
                            <input type="file" name="banner_mobile">
                            <span class="text-danger">
                                <?php echo isset($validation) ? form_errors($validation, 'banner_mobile') : ''; ?>
                                <?php echo isset($bannerMobile_dim) ? $bannerMobile_dim : ''; ?>
                            </span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group col-sm-6">
                        <label>Ativo</label>
                        <select name="ativo" class="form-control">
                            <option value="1" <?php echo ($result['ativo'] ?? set_value('ativo')) == 1 ? 'selected' : '' ?>>Sim</option>
                            <option value="0" <?php echo ($result['ativo'] ?? set_value('ativo')) == 0 ? 'selected' : '' ?>>Não</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Site</label>
                        <select name="site_id" class="form-control">
                            <option value="<?php echo null; ?>">Selecione um site</option>
                            <?php foreach ($sites as $site) : ?>
                                <option value="<?php echo $site['id']; ?>" <?php echo ($result['site_id'] ?? set_value('site_id')) == $site['id'] ? 'selected' : '' ?>><?php echo $site['slug']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <label>Texto</label> 
                        <textarea class="form-control" rows="3" name="texto"><?php echo $result['texto'] ?? set_value('texto') ?></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
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

