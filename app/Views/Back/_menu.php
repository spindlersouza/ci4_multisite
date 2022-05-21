<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php echo base_url('admin/dashboard'); ?>">Double One</a>
    </div>
    <ul class="nav navbar-right top-nav">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo session('admin_usuario_nome'); ?><b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><a href="<?php echo base_url('admin/infosite'); ?>"><i class="fa fa-fw fa-info-circle"></i> Informações do Site</a></li>
                <li><a href="<?php echo base_url('admin/config'); ?>"><i class="fa fa-fw fa-gears"></i> Configurações</a></li>
                <li><a href="<?php echo base_url('admin/auth/list'); ?>"><i class="fa fa-fw fa-users"></i> Usuários</a></li>
                <li class="divider"></li>
                <li><a href="<?php echo base_url('admin/logout'); ?>"><i class="fa fa-fw fa-power-off"></i> Sair</a></li>
            </ul>
        </li>
    </ul>
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            <li data-active="banners">
                <a href="javascript:;" data-toggle="collapse" data-target="#sub-banners" aria-expanded="<?php echo $menu['aria-expanded'] ?? 'false'; ?>">
                    <i class="fa fa-fw fa fa-fw fa-image"></i> Banners <i class="fa fa-fw fa-caret-down"></i>
                </a>
                <ul id="sub-banners" class="<?php echo $menu['collapse in'] ?? 'collapse'; ?>" aria-expanded="<?php echo $menu['aria-expanded'] ?? 'false'; ?>">
                    <li><a href="<?php echo base_url('admin/banner/indexTipos/1'); ?>">&raquo; Topo Home </a></li>
                    <li><a href="<?php echo base_url('admin/banner/indexTipos/2'); ?>">&raquo; Meio Home </a></li>
                    <li><a href="<?php echo base_url('admin/banner/indexTipos/3'); ?>">&raquo; Baixo Home </a></li>
                    <li><a href="<?php echo base_url('admin/banner/indexTipos/4'); ?>">&raquo; Baixo Home - Rodapé </a></li>
                </ul>
            </li>
            <li data-active="duvidas"><a href="<?php echo base_url('admin/duvidas'); ?>"><i class="fa fa-fw fa-question-circle"></i>Dúvidas Frequentes</a></li>
            <li data-active="lojas"><a href="<?php echo base_url('admin/lojas'); ?>"><i class="fa fa-fw fa-home"></i>Lojas</a></li>
            <li data-active="news"><a href="<?php echo base_url('admin/news'); ?>"><i class="fa fa-fw fa-home"></i>News</a></li>
            <li data-active="paginas-institucionais">
                <a href="javascript:;" data-toggle="collapse" data-target="#sub-politicas" aria-expanded="<?php echo $menu['aria-expanded'] ?? 'false'; ?>">
                    <i class="fa fa-fw fa-info-circle"></i> Páginas <i class="fa fa-fw fa-caret-down"></i>
                </a>
                <ul id="sub-politicas" class="<?php echo $menu['collapse in'] ?? 'collapse'; ?>" aria-expanded="<?php echo $menu['aria-expanded'] ?? 'false'; ?>">
                    <li><a href="<?php echo base_url('admin/paginas/nossas-lojas'); ?>">&raquo; Nossas Lojas </a></li>
                    <li><a href="<?php echo base_url('admin/paginas/duvidas-frequentes'); ?>">&raquo; Dúvidas Frequentes </a></li>
                    <li><a href="<?php echo base_url('admin/paginas/politica-privacidade'); ?>">&raquo; Politicas de Privacidade </a></li>
                    <li><a href="<?php echo base_url('admin/paginas/termos-uso'); ?>">&raquo; Termos de Uso </a></li>
                    <li><a href="<?php echo base_url('admin/paginas/trocas-devolucoes'); ?>">&raquo; Trocas e Devoluções </a></li>
                    <li><a href="<?php echo base_url('admin/paginas/news'); ?>">&raquo; Newsletter </a></li>
                </ul>
            </li>
            <li data-active="cupons"><a href="<?php echo base_url('admin/cupom'); ?>"><i class="fa fa-fw fa-ticket"></i> Cupons de Desconto</a></li>
            <li data-active="clientes"><a href="<?php echo base_url('admin/clientes'); ?>"><i class="fa fa-fw fa-users"></i> Clientes</a></li>
            <li data-active="topicos"><a href="<?php echo base_url('admin/topicos'); ?>"><i class="fa fa-fw fa-image"></i>Tópicos</a></li>
            <li data-active="pedidos"><a href="<?php echo base_url('admin/pedidos'); ?>"><i class="fa fa-fw fa-image"></i>Pedidos</a></li>
            <li data-active="frete"><a href="<?php echo base_url('admin/fretegratis'); ?>"><i class="fa fa-fw fa-truck"></i> Frete Grátis</a></li>

            <li><br /></li>
        </ul>
    </div>
</nav>