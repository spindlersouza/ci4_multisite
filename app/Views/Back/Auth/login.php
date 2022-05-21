<section>	
    <div class="container">
        <div class="login-container">
            <div id="output"></div>
            <div class="avatar"><img src="<?php echo base_url('public/Back/assets/img/logo.png'); ?>" class="img-responsive"/></div>
            <?php if (!empty(session()->getFlashdata('erroLogin'))): ?>
            <div class="alert alert-danger"><?php echo session()->getFlashdata('erroLogin'); ?> </div>
            <?php endif; ?>
            <div class="form-box">
                <form method="post" action="<?php echo base_url('admin/login'); ?>">
                    <?php echo csrf_field(); ?>
                    <input name="login" type="text" placeholder="login" value="<?php echo set_value('login') ?>" autofocus>
                    <span class="text-danger"><?php echo isset(session()->getFlashdata('error')['login']) ? session()->getFlashdata('error')['login'] : ''; ?></span>
                    <br />
                    <input type="password" name="password" placeholder="senha">
                    <span class="text-danger"><?php echo isset(session()->getFlashdata('error')['password']) ? session()->getFlashdata('error')['password'] : ''; ?></span>
                    <button class="btn btn-info btn-block login" type="submit">Entrar</button>
                </form>
            </div>
        </div>
    </div>
</section>
