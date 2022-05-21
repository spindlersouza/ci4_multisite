<header id="header" class="header header-container clearfix">
    <div class="clearfix py-3 py-md-0 py-lg-3" id="site-header-inner">
        <div class="row my-3 my-md-0 mx-3 py-3 py-lg-0 px-lg-3 menu-mobile-box">
            <div class="col-md-4 d-none d-lg-block py-3">
                <a href="<?php echo base_url('lojas'); ?>">
                    <i class="fa fa-map-marker"></i>&nbsp;Nossas Lojas
                </a>
            </div>
            <div id="logo" class="logo text-center col-md-4 d-none d-md-block py-2 py-md-0">
                <a href="/" title="logo">
                    <img src="<?php echo base_url('public/Front/assets/img/logo.png'); ?>" alt="image">
                </a>
            </div>
            <a class="menu-mobile d-block d-lg-none" href="javascript:void(0);" onclick="myMenu()">
                <div class="mobile-button">
                    <span></span>
                </div>
            </a>
            <ul class="menu-extra col-md-4 d-flex justify-content-end">
                <li class="box-search mx-3">
                    <form role="search" method="get" class="header-search-form h-100" action="#">
                        <input type="text" value="" name="s" class="header-search-field h-100" placeholder="Buscar...">
                        <button type="submit" class="header-search-submit h-100 center-center" title="Search"><i class="fa fa-search" style="color: #181818;"></i></button>
                        <!-- Edu, a página de resultados será a mesma da Categoria, porém com o filtro da busca  -->
                    </form>
                </li>
                <!-- Carrinho -->
                <li class="box-cart nav-top-cart-wrapper center-center">
                    <a class="icon_cart nav-cart-trigger active" href="#"><span>3</span></a>
                    <div class="nav-shop-cart">
                        <div class="widget_shopping_cart_content cart-modal">
                            <div class="woocommerce-min-cart-wrap cart-modal">
                                <div class="row border-all">
                                    <div class="col-4">
                                        <img class="img-fit-cart" src="<?php echo base_url('public/Front/assets/img/shop/sh-4/17.jpg'); ?>" />
                                    </div>
                                    <div class="col-6">
                                        <b class="text-uppercase">Nome do Produto</b>
                                        <p>Quantidade:<b class="text-uppercase"> 1 </b></p>
                                        <p>Valor: <b> R$ 89,99 </b></p>
                                    </div>
                                    <div class="col-2 px-1">
                                        <form method="post" action="" class="form-remove-carrinho text-center my-2">
                                            <button class="remover-produto btn btn-gray btn-xs" type="submit"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </div>
                                </div>
                                <div class="row border-all">
                                    <div class="col-4">
                                        <img class="img-fit-cart" src="<?php echo base_url('public/Front/assets/img/shop/sh-4/22.jpg'); ?>" />
                                    </div>
                                    <div class="col-6">
                                        <b class="text-uppercase">Nome do Produto</b>
                                        <p>Quantidade:<b class="text-uppercase"> 1 </b></p>
                                        <p>Valor: <b> R$ 69,99 </b></p>
                                    </div>
                                    <div class="col-2 px-1">
                                        <form method="post" action="" class="form-remove-carrinho text-center my-2">
                                            <button class="remover-produto btn btn-gray btn-xs" type="submit"><i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div class="row border-all">
                                    <div class="col-4">
                                        <img class="img-fit-cart" src="<?php echo base_url('public/Front/assets/img/shop/sh-4/25.jpg'); ?>" />
                                    </div>
                                    <div class="col-6">
                                        <b class="text-uppercase">Nome do Produto</b>
                                        <p>Quantidade:<b class="text-uppercase"> 2 </b></p>
                                        <p>Valor: <b> R$ 58,00 </b></p>
                                    </div>
                                    <div class="col-2 px-1">
                                        <form method="post" action="" class="form-remove-carrinho text-center my-2">
                                            <button class="remover-produto btn btn-gray btn-xs" type="submit"><i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div class="row border-all">
                                    <p class="text-center w-100">Total do carrinho:<b class="text-uppercase"> R$ 217,98 </b></p>
                                </div>
                                <div class="row mt-4">
                                    <a class="themesflat-button center-center w-100 px-0 rounded-0 bg-accent has-shadow" href="<?php echo base_url('carrinho'); ?>">Ver Carrinho</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    </li>
            </ul>
        </div>
    </div>
    <!-- menu mobile  -->
    <div id="myMenu" class="p-3" style="border-top: 2px solid #1818184b;">
        <nav id="mainnav" class="mainnav">
            <ul class="menu row">
                <?php foreach ($menus as $menu) : ?>
                <li class="col-12"><a href="<?php echo base_url($menu['slug']); ?>"><?php echo $menu['nome'] ?></a></li>
                <?php endforeach; ?>
            </ul>

        </nav>
    </div>
    <!-- menu desktop  -->
    <div class="menu-bottom d-none d-lg-block">
        <div class="nav-wrap">
            <nav id="mainnav" class="mainnav mx-3">
                <ul class="menu d-flex justify-content-start">
                    <?php foreach ($menus as $menu) : ?>
                        <li>
                            <a href="<?php echo base_url($menu['slug']); ?>"><?php echo $menu['nome'] ?></a>
                            <ul class="submenu">
                                <div class="" style="margin: 0 15vw 0 35vw;">
                                    <div class="row">
                                        <div class="col-8 row d-flex justify-content-between">
                                            <div class="col-4 mb-3 text-left">
                                                <?php foreach ($submenus[$menu['id']] as $submenu) : ?>
                                                    <a href="<?php echo base_url($menu['slug'] . '/' . $submenu['slug']); ?>"><?php echo $submenu['nome']; ?></a><br>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                        <?php if($menu['imagem'] != '') : ?>
                                        <div class="col-4">
                                            <a href="<?php echo base_url($menu['slug']); ?>">
                                                <img class="img-fit" src="<?php echo base_url('public/Front/upload/produtos/' . $menu['imagem']); ?>" alt="image">
                                            </a>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </ul>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        </div>

    </div>
</header>
