<?php echo $this->extend('admin'); ?>
<?php echo $this->section('content'); ?>

<span data-active="duvidas"></span>
<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header">Dúvidas Frequentes</h2>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('admin/dashboard') ?>">Home</a></li>
            <li class="active">Dúvidas Frequentes</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <a href="<?php echo base_url('admin/duvidas/cadastro'); ?>"> <button class="btn btn-sm btn-primary">Cadastrar</button> </a>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>

                <th class="text-left">Dúvida</th>
                <th class="p5">Resposta</th>
                <th class="p5">Alterar</th>
                <th class="p5">Excluir</th>
                </thead>
                <tbody>
                    <?php foreach ($duvidas as $result) : ?>
                        <tr>
                            
                            <td class="text-left"><?php echo $result['duvida']; ?> </td>
                            <td>
                                <?php if (!empty($result['resposta'])) { ?>
                                    <a class="open-modal" data-toggle="modal" data-target="<?php echo '#modal-texto-' . $result['id']; ?>" href="#">
                                        <i class="fa fa-list-alt"></i> 
                                    </a>
                                <?php } ?>
                            </td>
                            <td><a href="<?php echo base_url('admin/duvidas/cadastro/' . $result['id']); ?>"><i class="fa fa-edit"></i></a></td>									
                            <td><a href="<?php echo base_url('admin/duvidas/delete/' . $result['id']); ?>"><i class="fa fa-trash confirm"></i></a></td>									
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php foreach ($duvidas as $result) : ?>
    <div id="<?php echo 'modal-texto-' . $result['id']; ?>" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="fa fa-times"></i>
                    </button>
                    <h4 class="modal-title h2-titulo-section">Resposta</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <p><?php echo $result['resposta']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<?php echo $this->endSection(); ?>
