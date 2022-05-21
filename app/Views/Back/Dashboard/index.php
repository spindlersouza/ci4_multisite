<?php echo $this->extend('admin'); ?>
<?php echo $this->section('content'); ?>
<span data-active="home"></span>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Bem vindo <small>Administrador</small></h1>
        <ol class="breadcrumb">
            <li class="active">Home</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <blockquote><h4> <i class="fa fa-file-text-o"></i>  Detalhes da Empresa </h4>  </blockquote>
        <p><i class="fa fa-clock-o"></i>Horário do Login: <span><b><?php echo date('d/m/Y') ?></b></span></p>
        <p><i class="fa fa-briefcase"></i>Empresa:<span><b><?php echo $info['nome']; ?></b></span></p>
        <p><i class="fa fa-star"></i> Nome: <span><b><?php echo $usuario['nome']; ?></b></span></p>
        <p><i class="fa fa-user"></i> Login: <span><b><?php echo $usuario['login']; ?></b></span></p>

        <hr />
    </div>
</div>
<?php echo $this->endSection(); ?>

