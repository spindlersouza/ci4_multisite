<?php echo $this->extend('admin'); ?>
<?php echo $this->section('content'); ?>
<span data-active="topicos"></span>
<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header">Tópicos</h2>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('admin/dashboard') ?>">Home</a></li>
            <li class="active">Tópicos</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <a href="<?php echo base_url('admin/topicos/cadastro'); ?>"> <button class="btn btn-sm btn-primary">Cadastrar</button> </a>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-left">Icone</th>
                        <th class="text-left">Titulo</th>
                        <th class="text-left">Texto</th>
                        <th class="p5">Link</th>
                        <th class="p5">Site</th>
                        <th class="p5">Alterar</th>
                        <!--<th class="p5">Excluir</th>-->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($topicos as $result) : ?>
                        <tr>
                            <td class="text-left"><i class="fa <?php echo $result['icone']; ?>"></i></td>
                            <td class="text-left"><?php echo $result['titulo']; ?> </td>
                            <td class="text-left"><?php echo $result['texto']; ?> </td>
                            <td class="text-left"><?php echo $result['link']; ?> </td>
                            <td class="text-left"><?php echo $sites[$result['site_id']]['slug']; ?> </td>
                            <td><a href="<?php echo base_url('admin/topicos/cadastro/' . $result['id']); ?>"><i class="fa fa-edit"></i></a></td>									
                            <!--<td><a href="<?php // echo base_url('admin/topicos/delete/' . $result['id']); ?>"><i class="fa fa-trash confirm"></i></a></td>-->									
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php echo $this->endSection(); ?>
