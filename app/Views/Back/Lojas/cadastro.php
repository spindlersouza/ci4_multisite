<?php echo $this->extend('admin'); ?>
<?php echo $this->section('content'); ?>
<span data-active="Lojas"></span>
<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header">Lojas</h2>
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
        <form enctype="multipart/form-data" action="<?php echo base_url('admin/lojas/save'); ?>" method="post">
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
                <div class="col-xs-12 col-sm-3">
                    <div class="form-group">
                        <label>Estado</label>
                        <select id="estado_id" name="estado_id" class="form-control">
                            <option>Selecione um estado</option>
                            <?php foreach ($estados as $uf) : ?>
                                <option value="<?php echo $uf['id']; ?>" <?php echo ($result['estado_id'] ?? set_value('estado_id')) == $uf['id'] ? 'selected' : '' ?>><?php echo $uf['nome']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="text-danger"><?php echo isset($validation) ? display_errors($validation, 'estado_id') : ''; ?></span>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-9">
                    <div class="form-group">
                        <label>Cidade</label>
                        <select id="cidade_id" name="cidade_id" class="form-control">
                            <?php if (($result['cidade_id'] ?? set_value('cidade_id')) != '') : ?>
                                <option>Selecione uma cidade</option>
                                <?php foreach ($cidades as $city) : ?>
                                    <option value="<?php echo $city['id']; ?>" <?php echo ($result['cidade_id'] ?? set_value('cidade_id')) == $city['id'] ? 'selected' : '' ?>><?php echo $city['nome']; ?></option>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <option>Selecione um estado</option>
                            <?php endif; ?>
                        </select>
                        <span class="text-danger"><?php echo isset($validation) ? display_errors($validation, 'cidade_id') : ''; ?></span>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12">
                    <div class="form-group">
                        <label>Localização</label>
                        <input type="text" name="localizacao" class="form-control" value="<?php echo $result['localizacao'] ?? set_value('localizacao') ?>"/>
                        <span class="text-danger"><?php echo isset($validation) ? display_errors($validation, 'localizacao') : ''; ?></span>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                        <label>Telefone</label> 
                        <input type="text" name="telefone" class="form-control" value="<?php echo $result['telefone'] ?? set_value('telefone') ?>"/>
                        <span class="text-danger"><?php echo isset($validation) ? display_errors($validation, 'telefone') : ''; ?></span>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                        <label>Whatsapp</label> 
                        <input type="text" name="whatsapp" class="form-control" value="<?php echo $result['whatsapp'] ?? set_value('whatsapp') ?>"/>
                        <span class="text-danger"><?php echo isset($validation) ? display_errors($validation, 'whatsapp') : ''; ?></span>
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
