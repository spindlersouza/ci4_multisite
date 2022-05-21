<?php echo $this->extend('admin'); ?>
<?php echo $this->section('content'); ?>
<span data-active="informacao_site"></span>
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
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-left">Site</th>
                        <th class="p5">Alterar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($infosite as $result) : ?>
                        <tr>
                            <td class="text-left"><?php echo ucfirst($result['site']); ?></td>
                            <td><a href="<?php echo base_url('admin/infosite/cadastro/' . $result['id']); ?>"><i class="fa fa-edit"></i></a></td>									
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php echo $this->endSection(); ?>
