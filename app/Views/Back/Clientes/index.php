<?php echo $this->extend('admin'); ?>
<?php echo $this->section('content'); ?>
<span data-active="clientes"></span>
<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header">Clientes</h2>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('admin/dashboard') ?>">Home</a></li>
            <li class="active">Clientes</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-left">Nome</th>
                        <th>CEP</th>
                        <th>E-mail</th>
                        <th>Telefone</th>
                        <th>Data Cadastro</th>
                        <th>Cadastro Completo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clientes as $result) : ?>
                        <tr>
                            <td class="text-left"><?php echo $result['nome']; ?> </td>
                            <td><?php echo $result['cep']; ?> </td>
                            <td><?php echo $result['email']; ?> </td>
                            <td><?php echo $result['telefone']; ?> </td>
                            <td><?php echo date('d/m/Y', strtotime($result['created_at'])); ?> </td>
                            <td>
                                <a class="open-modal" data-toggle="modal" data-target="#modal-cadastro-<?php echo $result['id']; ?>" href="#">
                                    <i class="fa fa-vcard-o"></i>
                                </a>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php foreach ($clientes as $result) : ?>
    <div id="modal-cadastro-<?php echo $result['id']; ?>" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
                    <h4 class="modal-title h2-titulo-section">Cadastro Completo</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <p><b>Nome: </b><?php echo $result['nome']; ?></p>
                            <p><b>E-mail: </b><?php echo $result['email']; ?></p>
                            <p><b>CPF: </b><?php echo $result['cpf']; ?></p>
                            <p><b>Data de Nascimento: </b><?php echo  date('d/m/Y', strtotime($result['data_nascimento'])); ?></p>
                            <p><b>CEP: </b><?php echo $result['cep']; ?></p>
                            <p><b>Endereço: </b><?php echo $result['endereco']; ?>, Nº: <?php echo $result['numero']; ?> <?php echo ($result['complemento'] != '') ? ' - ' . $result['complemento'] : ''; ?></p>
                            <p><b>Bairro: </b><?php echo $result['bairro']; ?></p>
                            <p><b>Cidade: </b><?php echo $result['cidade']; ?></p>
                            <p><b>UF: </b><?php echo $result['uf']; ?></p>
                            <p><b>Telefone Contato: </b><?php echo $result['telefone']; ?></p>
                            <p><b>Telefone Celular: </b><?php echo $result['celular']; ?></p>
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
