<?php echo $this->extend('admin'); ?>
<?php echo $this->section('content'); ?>
<span data-active="pedidos"></span>
<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header">Relatório de Vendas</h2>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('admin/dashboard') ?>">Home</a></li>
            <li class="active">Relatório de Vendas</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="p5">Código</th>
                        <th>Cliente</th>
                        <th>Data</th>
                        <th>Total</th>
                        <th>Forma pagamento</th>
                        <th class="p5 nowrap">Ver Pedido</th>
                        <th>Status</th>
                        <th class="p5 nowrap">Situação e Rastreio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedidos as $result) : ?>
                        <tr>
                            <td class="p5">#<?php echo $result['id']; ?></td>
                            <td class="text-left"><?php echo $result['cliente_nome']; ?> </td>
                            <td><?php echo date('d/m/Y H:i:s', strtotime($result['data_compra'])); ?> </td>
                            <td> R$ <?php echo number_format($result['total'], 2, ',', '.'); ?> </td>
                            <td class="text-left"><?php echo $result['pagamento']; ?> </td>
                            <td>
                                <a href="<?php echo base_url('admin/pedidos/' . $result['id']); ?>" target="_blank">
                                    <i class="fa fa-clipboard"></i>
                                </a>
                            </td>
                            <td class="text-left"><?php echo $result['pagamento_status']; ?> </td>

                            <td>
                                <a class="open-modal" data-toggle="modal" data-target="#modal-info-10927" href="#">
                                    <i class="fa fa-truck"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php echo $this->endSection(); ?>
