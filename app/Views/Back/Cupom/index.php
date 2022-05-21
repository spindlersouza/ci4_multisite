<?php echo $this->extend('admin'); ?>
<?php echo $this->section('content'); ?>
<span data-active="cupons"></span>
<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header">Cupons de Desconto</h2>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('admin/dashboard') ?>">Home</a></li>
            <li class="active">Cupons de Desconto</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <a href="<?php echo base_url('admin/cupom/cadastro'); ?>"> <button class="btn btn-sm btn-primary">Cadastrar</button> </a>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-left">Nome</th>
                        <th>Código</th>
                        <th>Valor</th>
                        <th>Data Início</th>
                        <th>Data Fim</th>
                        <th>Site</th>
                        <th class="p5">Ativo</th>
                        <th class="p5">Alterar</th>
                        <th class="p5">Excluir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cupons as $result) : ?>
                        <tr>
                            <td class="text-left"><?php echo $result['nome']; ?></td>
                            <td><?php echo $result['codigo']; ?></td>
                            <td><?php echo $result['valor']; ?> </td>
                            <td><?php echo implode('/', array_reverse(explode('-', $result['data_inicio']))); ?> </td>
                            <td><?php echo implode('/', array_reverse(explode('-', $result['data_fim']))); ?> </td>
                            <td><?php echo ucfirst($sites[$result['site_id']]['slug']); ?> </td>
                            <td>
                                <div>
                                    <i class="editAtivoAdmin fa fa-toggle-on <?php echo $result['ativo'] == '1' ? '' : 'fa-flip-horizontal'; ?>" 
                                       style="color: <?php echo $result['ativo'] == '1' ? '#508b47' : '#9d4444'; ?> ;"
                                       data-col="<?php echo $result['id']; ?>" data-tb="cupom"></i>
                                </div>
                            </td>									
                            <td><a href="<?php echo base_url('admin/cupom/cadastro/' . $result['id']); ?>"><i class="fa fa-edit"></i></a></td>									
                            <td><a href="<?php echo base_url('admin/cupom/delete/' . $result['id']); ?>"><i class="fa fa-trash"></i></a></td>									
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php echo $this->endSection(); ?>
