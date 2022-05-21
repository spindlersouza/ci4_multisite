<?php echo $this->extend('admin'); ?>
<?php echo $this->section('content'); ?>
<span data-active="frete"></span>
<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header">Frete Grátis</h2>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('admin/dashboard') ?>">Home</a></li>
            <li class="active">Frete Grátis</li>
        </ol>
    </div>
</div>


<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <?php foreach ($fretes as $result) : ?>
            <div class="col-xs-12">
                <div class="form-group col-sm-6">
                    <label>Valor mínimo em compras para Frete Grátis - <?php echo ucfirst($result['site']); ?></label>
                    <input type="text" id="valor_frete_<?php echo $result['site_id']; ?>" name="valor" class="form-control moeda_real" value="<?php echo $result['valor']; ?>" />
                    <p><small>*Deixe este campo vazio ou 0 (zero) para desabilitar o Frete Grátis</small></p>
                </div>
                <div class="form-group col-sm-1">
                    <input type="button" data-site="<?php echo $result['site_id']; ?>" data-id="<?php echo $result['id']; ?>" value="Alterar" class="btn btn-info alteraFrete" />
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php echo $this->endSection(); ?>
