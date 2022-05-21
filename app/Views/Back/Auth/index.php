<?php echo $this->extend('admin'); ?>
<?php echo $this->section('content'); ?>
<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header">Usuários</h2>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('admin'); ?>">Home</a></li>
            <li class="active">Usuários</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <a href="<?php echo base_url('admin/auth/cadastro'); ?>"> 
            <button class="btn btn-sm btn-primary">Cadastrar</button> 
        </a>
        <div class="table-responsive">
            <table class="table table-striped datatable">
                <thead>
                    <tr>
                        <th class="text-left">Nome</th>
                        <th>Login</th>
                        <th>E-mail</th>
                        <th>Permissão</th>
                        <th>Último Login</th>
                        <th class="p5">Alterar</th>
                        <th class="p5">Excluir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $result) : ?>
                        <tr>
                            <td class="text-left"><?php echo $result['nome']; ?> </td>
                            <td><?php echo $result['login']; ?> </td>
                            <td><?php echo $result['email']; ?> </td>
                            <td><?php echo $result['permissao']; ?> </td>
                            <td><?php echo $result['data_hora'] ?> </td>
                            <td>
                                <a href="<?php echo base_url('admin/auth/cadastro?' . $result['id_usuario']); ?>"> 
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>									
                            <td>
                                <form method="post" action="<?php echo $urlC . 'acao'; ?>">
                                    <button type="button" class="fa fa-trash" data-toggle="confirmation"></button>
                                </form>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php echo $this->endSection(); ?>