<?php echo $this->extend('admin'); ?>
<?php echo $this->section('content'); ?>
<span data-active="banners"></span>
<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header">Banners</h2>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('admin/dashboard') ?>">Home</a></li>
            <li class="active">Banners</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <a href="<?php echo base_url('admin/banner/cadastro'); ?>"> <button class="btn btn-sm btn-primary">Cadastrar</button> </a>
        <div class="table-responsive">
            <table class="table table-striped datatable-reorder">
                <thead>
                    <tr>
                        <th class="text-left">Nome</th>
                        <th>Link</th>
                        <th>Data Início</th>
                        <th>Data Fim</th>
                        <th class="p5">Imagem</th>
                        <th class="p5">Imagem Mobile</th>
                        <th class="p5">Texto</th>
                        <th class="p5">Ativo</th>
                        <th class="p5">Alterar</th>
                        <th class="p5">Excluir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($banners as $result) : ?>
                        <tr>
                            <td class="text-left"><?php echo $result['nome'] ?? ''; ?> <?php echo $result['ativo']; ?></td>
                            <td><?php echo $result['link'] ?? ''; ?> </td>
                            <td><?php echo $result['data_inicio'] ?? ''; ?> </td>
                            <td><?php echo $result['data_fim'] ?? ''; ?> </td>
                            <td>
                                <?php if (!empty($result['banner'])) { ?>
                                    <a href="<?php echo base_url('public/upload/banner/' . $result['banner']); ?>" class="fancybox"><i class="fa fa-picture-o"></i></a>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if (!empty($result['banner_mobile'])) { ?>
                                    <a href="<?php echo base_url('public/upload/banner/' . $result['banner_mobile']); ?>" class="fancybox"><i class="fa fa-picture-o"></i></a>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if (!empty($result['texto'])) { ?>
                                    <a class="open-modal" data-toggle="modal" data-target="<?php echo '#modal-texto-' . $result['id']; ?>" href="#">
                                        <i class="fa fa-list-alt"></i>
                                    </a>
                                <?php } ?>
                            </td>
                            <td>
                                <div>
                                    <i class="editAtivoAdmin fa fa-toggle-on <?php echo $result['ativo'] == '1' ? '' : 'fa-flip-horizontal'; ?> " 
                                       style="color: <?php echo $result['ativo'] == '1' ? '#508b47' : '#9d4444'; ?> ;"
                                       data-col="<?php echo $result['id']; ?>" data-tb="banner"
                                       ></i>
                                </div>
                            </td>									
                            <td><a href="<?php echo base_url('admin/banner/cadastro/' . $result['id']); ?>"><i class="fa fa-edit"></i></a></td>									
                            <td><a href="<?php echo base_url('admin/banner/delete/' . $result['id']); ?>"><i class="fa fa-trash confirm"></i></a></td>									
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php foreach ($banners as $result) : ?>
    <div id="<?php echo 'modal-texto-' . $result['id']; ?>" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
                    <h4 class="modal-title h2-titulo-section">Texto</h4>
                </div>
                <div class="modal-body">
                    <div class="row"><div class="col-xs-12"><p><?php echo $result['texto']; ?></p></div></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button></div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<?php echo $this->endSection(); ?>

