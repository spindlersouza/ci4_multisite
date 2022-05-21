<div class="container-fluid px-0 menu-top" id="topo">
    <div class="my-0 py-0 h-100">
        <div class="row my-0 border-all d-md-none">
            <?php if (1 == 2) : ?>
                <a class="col-4 themesflat-button bg-accent <?php echo $nuez ?? ''; ?> p-2" href="<?php echo $linksite['nuez'] ?>" style="line-height: 7px;">
                    <img src="<?php echo base_url('public/Front/assets/img/logo.png'); ?>" alt="image" style="width: 60px;">
                </a>
                <a class="col-4 themesflat-button bg-accent bg-custom <?php echo $vibrance ?? ''; ?> p-2" href="<?php echo $linksite['vibrance'] ?>" style="line-height: 7px; filter: opacity(0.65);">
                    <img src="<?php echo base_url('public/Front/assets/img/logov.png'); ?>" alt="image" style="width: 60px;">
                </a>
                <a class="col-4 themesflat-button bg-accent <?php echo $milan ?? ''; ?> p-2" href="<?php echo $linksite['milan'] ?>" style="line-height: 7px;">
                    <img src="<?php echo base_url('public/Front/assets/img/logom.png'); ?>" alt="image" style="width: 60px;">
                </a>
            <?php endif; ?>
        </div>

        <div class="row mx-3 my-0 py-1 h-100 center-center" style="position: relative; z-index: 999;">
            <div class="col-md-8 col-lg-5 h-100 py-0 d-none d-md-flex">
                <?php if (1 == 2) : ?>

                    <a class="themesflat-button bg-accent <?php echo $nuez ?? ''; ?> p-2" href="<?php echo $linksite['nuez'] ?>" style="line-height: 8px; ">
                        <img src="<?php echo base_url('public/Front/assets/img/logo.png'); ?>" alt="image" style="width: 60px;">
                    </a>
                    <a class="themesflat-button bg-accent bg-custom <?php echo $vibrance ?? ''; ?> p-2" href="<?php echo $linksite['vibrance'] ?>" style="line-height: 8px; ">
                        <img src="<?php echo base_url('public/Front/assets/img/logov.png'); ?>" alt="image" style="width: 60px;">
                    </a>
                    <a class="themesflat-button bg-accent <?php echo $milan ?? ''; ?> p-2" href="<?php echo $linksite['milan'] ?>" style="line-height: 8px; ">
                        <img src="<?php echo base_url('public/Front/assets/img/logom.png'); ?>" alt="image" style="width: 60px;">
                    </a>
                <?php endif; ?>

            </div>
            <div id="logo" class="logo text-center col-5 d-md-none mx-0 py-1 py-sm-0">
                <a href="/" title="logo">
                    <img src="<?php echo base_url('public/Front/assets/img/logov.png'); ?>" alt="image" style="width: 100%;">
                </a>
            </div>
            <div class="col-7 col-md-4 col-lg-7 d-flex justify-content-end h-100 py-1 login" style="align-items: center;">
                <?php if (session('cliente_id') == '') : ?>
                    <a class="d-none d-lg-block font-size-mobile" href="<?php echo base_url('login'); ?>"><i class="fa fa-user"></i>&nbsp;Entrar ou Cadastrar-se</a>
                    <a class="d-block d-lg-none" href="<?php echo base_url('login'); ?>"><i class="fa fa-user"></i></a> &emsp;
                <?php endif; ?>
                <a class="d-none d-lg-block font-size-mobile" href="javascript:void(0);" onclick="Atendimento()"><i class="fa fa-weixin"></i>&nbsp;Atendimento</a>
                <a class="d-block d-lg-none" href="javascript:void(0);" onclick="Atendimento()"><i class="fa fa-weixin"></i></a> &emsp;
                <?php if (session('cliente_id') != '') : ?>
                    <p>|&nbsp; <span class="font-size-mobile"><a href="javascript:void(0);" onclick="Conta()"><i class="fa fa-user"></i>&nbsp;Olá, <?php echo session('cliente_primiero_nome'); ?></a></span></p>
                <?php endif; ?>
            </div>

            <!-- Modal Login  -->
            <div id="Login" class="" style="display: none;">
                <i class="fa fa-caret-up d-none d-lg-block" style="position: absolute; top: -10px; right: 45px;"></i>
                <div>
                    <a href="javascript:void(0);" onclick="LoginForgot()">Receber código de acesso por email</a><br>
                    <a href="javascript:void(0);" onclick="LoginAcesso()">Entrar com email e senha</a><br>
                    <!--<a href="https://accounts.google.com/" onclick="window.open(this.href, this.target, 'width=754,height=479'); return false;" target="_blank">Entrar com Google</a><br>-->
                    <!--<a href="https://www.facebook.com/" onclick="window.open(this.href, this.target, 'width=754,height=479'); return false;" target="_blank">Entrar com Facebook</a><br>-->
                    <!--<fb:login-button scope="public_profile,email" onlogin="checkLoginState();"></fb:login-button>-->
                    <a href="javascript:void(0);" onclick="LoginClose()" id="LoginClose">X</a>
                </div>

                <div id="LoginForgot" class="" style="display: none;">
                    <form class="w-100" action="#" method="post" accept-charset="utf-8">
                        <div class="w-100">
                            <div class="input border-btn">
                                <input type="email" name="email" placeholder="Seu Email">
                            </div>
                            <div class="button mt-2">
                                <button class="btn btn-gray border-btn text-black pull-right" type="button" onclick="LoginCode()">ENVIAR</button>
                            </div>
                        </div>
                    </form>
                    <a href="javascript:void(0);" onclick="LoginVoltar()"><i class="fa fa-arrow-left"></i>&nbsp;Voltar</a><br>
                </div>

                <div id="LoginCode" class="" style="display: none;">
                    <form class="w-100" action="#" method="post" accept-charset="utf-8">
                        <div class="w-100">
                            <div class="input border-btn">
                                <input type="text" name="code" placeholder="Adicione seu código de acesso">
                                <input type="password" name="password" placeholder="Senha">
                                <input type="password" name="password" placeholder="Confirme sua Senha">

                            </div>
                            <div class="button mt-2">
                                <button class="btn btn-gray border-btn text-black pull-right" type="button">ENVIAR</button>
                            </div>
                        </div>
                    </form>
                    <a href="javascript:void(0);" onclick="LoginVoltar()"><i class="fa fa-arrow-left"></i>&nbsp;Voltar</a><br>
                </div>
                <div id="LoginAcesso" class="" style="display: none;">
                    <form class="w-100" action="#" method="post" accept-charset="utf-8">
                        <div class="w-100">
                            <div class="input border-btn">
                                <input type="email" name="email" placeholder="Seu Email">
                                <input type="password" name="password" placeholder="Senha">
                            </div>
                            <div class="button my-2">
                                <button class="btn btn-gray border-btn text-black pull-right" type="button">ENTRAR</button>
                            </div>
                            <div>
                                <a href="javascript:void(0);" onclick="LoginVoltar()"><i class="fa fa-arrow-left"></i>&nbsp;Voltar</a><br>
                            </div>
                        </div>
                    </form>
                    <div class="text-center mt-4">
                        <a href="javascript:void(0);" onclick="LoginForgot()">Esqueci a senha</a><br>
                        <hr class="m-0">
                        <a href="javascript:void(0);" onclick="LoginForgot()">Não tem uma conta? Cadastrar-se</a><br>
                    </div>
                </div>

            </div>

            <!-- Modal Atendimento  -->
            <div id="Atendimento" class="" style="display: none;">
                <i class="fa fa-caret-up d-none d-lg-block" style="position: absolute; top: -10px; right: 120px;"></i>
                <div>
                    <!-- <a href=""><i class="fa fa-commenting"></i>&emsp;Chat Online</a><br> -->
                    <a href="mailto:sac@instintointimo.com.br" target="_blank"><i class="fa fa-envelope"></i>&emsp;Mande um email</a><br>
                    <a href="https://api.whatsapp.com/send?phone=5505499266-9406" target="_blank"><i class="fa fa-whatsapp"></i>&emsp;Whatsapp</a><br>

                    <a href="javascript:void(0);" onclick="AtendimentoClose()" id="AtendimentoClose">X</a>
                </div>
            </div>

            <!-- Modal Minha conta  -->
            <div id="Conta" class="" style="display: none;">
                <i class="fa fa-caret-up d-none d-lg-block" style="position: absolute; top: -10px;"></i>
                <div>
                    <a href="<?php echo base_url('minha-conta'); ?>">&emsp;Minha Conta</a><br>
                    <hr>
                    <a href="<?php echo base_url('/logout'); ?>">&emsp;Sair</a><br>
                    <a href="javascript:void(0);" onclick="ContaClose()" id="ContaClose">X</a>

                </div>

            </div>
        </div>
    </div>
</div>