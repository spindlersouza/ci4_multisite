<header id="header" class="header header-container clearfix">
    <div class="clearfix py-3 py-md-0 py-lg-3" id="site-header-inner">
        <div class="row my-3 my-md-0 mx-3 py-3 py-lg-0 px-lg-3 menu-mobile-box">
            <div class="col-md-4 d-none d-lg-block py-3">
                <!-- <a href="<?php echo base_url('lojas'); ?>">
                    <i class="fa fa-map-marker"></i>&nbsp;Nossas Lojas
                </a> -->
            </div>
            <div id="logo" class="logo text-center col-md-4 d-none d-md-block py-2 py-md-0">
                <a href="/" title="logo">
                    <img src="<?php echo base_url('public/Front/assets/img/logov.png'); ?>" alt="image">
                </a>
            </div>
            <a class="menu-mobile d-block d-lg-none" href="javascript:void(0);" onclick="myMenu()">
                <div class="mobile-button">
                    <span></span>
                </div>
            </a>
            <ul class="menu-extra col-md-4 d-flex justify-content-end">
                <li class="box-search mx-3">
                    <form role="search" method="post" class="header-search-form h-100" action="/busca">
                        <input type="text" value="<?php echo session('busca') ?? ''; ?>" name="busca" class="header-search-field h-100" placeholder="Buscar...">
                        <button type="submit" class="header-search-submit h-100 center-center" title="Search"><i class="fa fa-search" style="color: #181818;"></i></button>
                    </form>
                </li>
                <li class="box-cart nav-top-cart-wrapper center-center">
                    <a class="icon_cart nav-cart-trigger active" href="#"><span id="quantidade_carrinho_itens"><?php echo $carrinhoTopo['quantidade']; ?></span></a>
                    <div class="nav-shop-cart">
                        <div class="widget_shopping_cart_content cart-modal">
                            <div class="woocommerce-min-cart-wrap cart-modal">
                                <div id="lista_itens_carrinho_topo" style="overflow: auto; overflow-x: hidden; max-height: 350px;">
                                    <?php if ($carrinhoItensTopo) : ?>
                                        <?php foreach ($carrinhoItensTopo as $item) : ?>
                                            <div class="row border-all" id="produtocarrinhotopo<?php echo $item['id']; ?>">
                                                <div class="col-4">
                                                    <?php if ($item['imagem'] != null) : ?>
                                                        <img class="img-fit-cart" src="/public/upload/produtos/thumb_200/<?php echo $item['imagem']; ?>" />
                                                    <?php endif; ?>
                                                </div>
                                                <div class="col-6 py-2">
                                                    <b class="text-uppercase" style="font-size: 12px; line-height: 20px;"><?php echo $item['nome']; ?></b>
                                                    <p>Quantidade:<b class="text-uppercase"><?php echo $item['quantidade']; ?></b></p>
                                                    <p>Valor: <b> R$ <?php echo $item['valor']; ?></b></p>
                                                </div>
                                                <div class="col-2 px-1">
                                                    <div class="form-remove-carrinho text-center my-2">
                                                        <button class="remover-produto btn btn-gray btn-xs" onclick="removeprodutocarrinhotopo(<?php echo $item['id']; ?>)"><i class="fa fa-trash"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                                <div class="row border-all">
                                    <p class="text-center w-100">Total do carrinho:<b class="text-uppercase" id="carrinho_topo_total">R$ <?php echo number_format($carrinhoTopo['subtotal'], 2, ',', '.'); ?></b></p>
                                </div>
                                <div class="row mt-4">
                                    <a class="themesflat-button center-center w-100 px-0 rounded-0 bg-accent has-shadow my-2" href="<?php echo base_url('/'); ?>">Continuar comprando</a>

                                    <a class="themesflat-button center-center w-100 px-0 rounded-0 bg-accent has-shadow my-2" href="<?php echo base_url('carrinho'); ?>">Finalizar Compra</a>
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
                                        <?php if ($menu['imagem'] != '') : ?>
                                            <div class="col-4">
                                                <a href="<?php echo base_url($menu['slug']); ?>"><img class="img-fit" src="<?php echo base_url('public/Front/upload/produtos/' . $menu['imagem']); ?>" alt="image"></a>
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