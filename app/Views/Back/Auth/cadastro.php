<?php echo $this->extend('admin'); ?>
<?php echo $this->section('content'); ?>
<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header">Usuários <small>/<?php echo esc($tipo); ?></small></h2>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('admin/dashboard'); ?>">Home</a></li>
            <li><a href="<?php echo base_url('admin/auth/list'); ?>">Usuários</a></li>
            <li class="active">Cadastrar Usuário</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <form enctype="multipart/form-data" action="<?php echo base_url('admin/auth/save'); ?>" method="post">
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" name="nome" class="form-control" value="<?php echo $usuario['nome'] ?? set_value('nome'); ?>"/>
                        <span class="text-danger"><?php echo isset($validation) ? display_errors($validation, 'nome') : ''; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Login</label>
                        <input type="text" name="login" class="form-control" value="<?php echo $usuario['login'] ?? set_value('login'); ?>"/>
                        <span class="text-danger"><?php echo isset($validation) ? display_errors($validation, 'login') : ''; ?></span>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                        <label>Senha</label>
                        <input type="text" name="password" class="form-control" value="<?php echo set_value('password'); ?>"/>
                        <span class="text-danger"><?php echo isset($validation) ? display_errors($validation, 'password') : ''; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Confirme a senha</label>
                        <input type="text" name="cpassword" class="form-control" value="<?php echo set_value('cpassword'); ?>"/>
                        <span class="text-danger"><?php echo isset($validation) ? display_errors($validation, 'cpassword') : ''; ?></span>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                        <!--<label>Permissão</label>-->
                        <!--<select name="id_nivel_acesso" class="form-control" required>-->
                        <!--<option value="">...selecione</option>-->
                        <?php // $query2 = $conn->query("SELECT * FROM nivel_acesso"); ?>
                        <?php // while ($result2 = $query2->fetch_array()) { ?>
                        <?php // if (!($result2['id'] == 1 && $_SESSION['login']['id_nivel_acesso'] == 2)) { ?>
                                <!--<option value="<?php // echo $result2['id'];  ?>">-->
                        <?php // echo $result2['permissao']; ?>
                        <!--</option>-->
                        <?php // } ?>
                        <?php // } ?>
                        <!--</select>-->
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group">
                        <input type="submit" value="Cadastrar" class="btn btn-success"/>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php echo $this->endSection(); ?>