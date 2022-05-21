<?php echo $this->extend('admin'); ?>
<?php echo $this->section('content'); ?>
<?php 


?>
<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header">Informações Site</h2>
        <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li class="active">Informações Site</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <form enctype="multipart/form-data" action="<?php echo base_url('admin/infosite/save'); ?>" method="post">
            <input type="hidden" name="id" value="<?php echo $result['id']; ?>" />
            <input type="hidden" name="site_id" value="<?php echo $result['site_id']; ?>" />
            <input type="hidden" name="created_usuario_id" value="<?php echo session('admin_usuario_id'); ?>" />
            <div class="row">
                <div class="form-group col-sm-12">
                    <label>Título do Site</label>
                    <input type="text" name="nome" class="form-control" value="<?php echo $result['nome']; ?>" required/>
                </div>
            </div>
            <hr />
            <div class="form-group col-sm-6">
                <label>Logo <small>(dimensões: 200x70px)</small></label>
                <?php if (!empty($result['logo'])) { ?>
                    <a href="<?php echo base_url('public/upload/infosite/' . $result['logo']); ?>" class="fancybox btn btn-default"><i class="fa fa-picture-o roxo"></i></a>
                <?php } ?>
                <span class="btn btn-default btn-file btn-file-lg"><input type="file" name="logo"></span>
            </div>
            <div class="form-group col-sm-6">
                <label>Banner Link (Home) <small>(dimensões: 950x700px)</small></label>
                <?php if (!empty($result['banner_link'])) { ?>
                    <a href="<?php echo base_url('public/upload/infosite/' . $result['banner_link']); ?>" class="fancybox btn btn-default"><i class="fa fa-picture-o roxo"></i></a>
                <?php } ?>
                <span class="btn btn-default btn-file btn-file-lg"><input type="file" name="banner_link"></span>
            </div>
            <hr />
            <div class="row">
                <div class="form-group col-sm-6">
                    <label>E-mail</label>
                    <input type="text" name="email" class="form-control" value="<?php echo $result['email']; ?>"/>
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-sm-6">
                    <label>Telefone</label>
                    <input type="text" name="telefone" class="form-control" value="<?php echo $result['telefone']; ?>"/>
                </div>
                <div class="form-group col-sm-6">
                    <label>WhatsApp <small>(atendimento)</small></label>
                    <input type="text" name="whatsapp" class="form-control" value="<?php echo $result['whatsapp']; ?>"/>
                </div>
            </div>
            <hr />
            <div class="row">
                <div class="form-group col-sm-6">
                    <label>Facebook</label>
                    <input type="text" name="facebook" class="form-control" value="<?php echo $result['facebook']; ?>"/>
                </div>
                <div class="form-group col-sm-6">
                    <label>Instagram</label>
                    <input type="text" name="instagram" class="form-control" value="<?php echo $result['instagram']; ?>"/>
                </div>
                <div class="form-group col-sm-6">
                    <label>Twitter</label>
                    <input type="text" name="twitter" class="form-control" value="<?php echo $result['twitter']; ?>"/>
                </div>
                <div class="form-group col-sm-6">
                    <label>LinkedIn</label>
                    <input type="text" name="linkedin" class="form-control" value="<?php echo $result['linkedin']; ?>"/>
                </div>
                <div class="form-group col-sm-6">
                    <label>YouTube</label>
                    <input type="text" name="youtube" class="form-control" value="<?php echo $result['youtube']; ?>"/>
                </div>
            </div>
            <hr />
            <div class="row">
                <div class="form-group col-sm-12">
                    <label>Mapa (código do Mapa Incorporado do Google)</label>
                    <?php if (!empty($result['mapa'])) { ?>
                        <div class="input-group">
                            <input type="text" name="mapa" class="form-control" value="<?php echo $result['mapa']; ?>">
                            <a class="btn btn-success input-group-addon open-modal" data-toggle="modal" data-target="#modal-mapa" href="#"><i class="fa fa-globe fa-inverse"></i></a>
                        </div>
                    <?php } else { ?>
                        <input type="text" name="mapa" class="form-control" value="<?php echo $result['mapa']; ?>"/>
                    <?php } ?>
                </div>
            </div>
            <hr />
            <div class="row">
                <div class="form-group col-sm-6">
                    <label>Cep</label> 
                    <input type="text" name="mapa" class="form-control" value="<?php echo $result['mapa']; ?>"/>
                </div>
                <div class="clearfix"></div>

                <div class="form-group col-sm-6">
                    <label>Estado</label>
                    <select id="estado_id" name="estado_id" class="form-control">
                        <option>Selecione um estado</option>
                        <?php foreach ($estados as $uf) : ?>
                            <option value="<?php echo $uf['id']; ?>" <?php echo ($result['estado_id'] ?? set_value('estado_id')) == $uf['id'] ? 'selected' : '' ?>><?php echo $uf['nome']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-sm-6">
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
                </div>
                <div class="form-group col-sm-6">
                    <label>Endereço</label> 
                    <input type="text" name="endereco" class="form-control" value="<?php echo $result['endereco']; ?>"/>
                </div>

                <div class="form-group col-sm-6">
                    <label>Bairro</label> 
                    <input type="text" name="bairro" class="form-control" value="<?php echo $result['bairro']; ?>"/>
                </div>
                <div class="form-group col-sm-6">
                    <label>Número</label> 
                    <input type="text" name="numero" class="form-control" value="<?php echo $result['numero']; ?>"/>
                </div>
                <div class="form-group col-sm-6">
                    <label>Complemento</label> 
                    <input type="text" name="complemento" class="form-control" value="<?php echo $result['complemento']; ?>"/>
                </div>
            </div>
            <div class="col-xs-12"><div class="form-group"><input type="submit" value="Alterar"  class="btn btn-info"/></div></div>
        </form>
    </div>
    <div id="modal-mapa" class="modal fade modal-map" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title h2-titulo-section">Mapa</h4>
                </div>
                <div class="modal-body">
                    <div class="row"><div class="col-xs-12"><?php echo $result['mapa']; ?></div></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php echo $this->endSection(); ?>
