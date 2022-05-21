<?php echo $this->extend('front'); ?>
<?php echo $this->section('content'); ?>
<!-- banner  -->
<div class="container-fluid slider px-0">
    <div class="h-100">
        <ul class="h-100 owl-carousel owl-slider owl-theme">
            <?php foreach ($banners_topo as $bannerT) : ?>
                <li class="h-100 bg-banners" style="background: url(<?php echo base_url('public/upload/banner/' . $bannerT['banner']); ?>) no-repeat; ">
                    <?php if ($bannerT['link']) : ?> <a href="<?php echo $bannerT['link']; ?>"> <?php endif; ?>
                        <div class="box-slider"></div>
                        <?php if ($bannerT['link']) : ?> </a> <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<div class="container-fluid slider-mobile px-0">
    <div class="h-100">
        <ul class="h-100 owl-carousel owl-slider owl-theme">
            <?php foreach ($banners_topo as $bannerTM) : ?>
                <li class="h-100 bg-banners-m" style="background: url(<?php echo base_url('public/upload/banner/' . $bannerTM['banner_mobile']); ?>) no-repeat; ">
                    <?php if ($bannerTM['link']) : ?> <a href="<?php echo $bannerTM['link']; ?>"> <?php endif; ?>
                        <div class="box-slider"></div>
                        <?php if ($bannerTM['link']) : ?> </a> <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<!-- produtos em destaque  -->
<?php if ($produtos_destaque) : ?>
    <section class="flat-row main-shop no-padding">
        <div class="">
            <div class="row mx-3">
                <div class="col-md-12">
                    <div class="title-section margin-bottom-50"><h2 class="title">Em Destaque</h2></div>
                    <div class="product-content product-fourcolumn clearfix anime-down">
                        <ul class="product style2 clearfix owl-carousel owl-one owl-theme">
                            <?php foreach ($produtos_destaque as $produto) : ?>
                                <li class="product-item ">
                                    <div class="product-thumb clearfix py-0">
                                        <a href="<?php echo base_url($produto['categoria'] . '/' . $produto['subcategoria'] . '/' . $produto['slug']) ?>">
                                            <img class="img-fit" src="<?php echo base_url('/public/upload/produtos/thumb_600/' . $produto['imagem']) ?>" alt="<?php echo $produto['slug']; ?>">
                                        </a>
                                    </div>
                                    <div class="product-info clearfix p-3">
                                        <span class="product-title"><?php echo $produto['nome']; ?></span>
                                        <div class="price">
                                            <ins>
                                                <?php if ($produto['promo'] > '0.00'): ?>
                                                    <span class="amount" style="text-decoration: line-through; font-size: 14px;">R$ <?php echo $produto['preco']; ?></span>
                                                <?php endif; ?>
                                                <span class="amount">R$ <?php echo ($produto['promo'] > '0.00') ? number_format($produto['promo'], 2, ',', '.') : number_format($produto['preco'], 2, ',', '.'); ?></span>
                                            </ins>
                                        </div>
                                        <!--<div class="parcelamento"><span>ou em 10x de R$ 00,00</span></div>-->
                                    </div>
                                    <div class="add-to-cart text-center"><a href="<?php echo base_url($produto['categoria'] . '/' . $produto['subcategoria'] . '/' . $produto['slug']) ?>">Ver Detalhes</a></div>
                                    <!--<a href="produto.html" class="like"><i class="fa fa-heart-o"></i></a>-->
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="divider h56"></div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>


<!-- tópicos  -->
<?php if ($topicos): ?>
    <section class="flat-row row-icon-box mail-chimp anime">
        <div class="">
            <div class="row mx-3 separator dark">
                <?php foreach ($topicos as $topico) : ?>
                    <div class="col-md-3">
                        <div class="flat-icon-box icon-left style-2 clearfix">
                            <div class="inner flat-content-box" data-margin="0 0 0 62px" data-mobilemargin="0 0 0 0">
                                <div class="icon-wrap">
                                    <i class="fa <?php echo $topico['icone']; ?>"></i>
                                </div>
                                <div class="text-wrap">
                                    <h5 class="heading"><a href="#"><?php echo $topico['titulo']; ?></a></h5>
                                    <p class="desc"><?php echo $topico['texto']; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>
<!-- banner promocional 1 -->
<?php if ($banners_meio) : ?>
    <div class="row-countdown bg-section bg-banners" style="
         background: url('<?php echo base_url('public/upload/banner/' . $banners_meio['banner']); ?>') no-repeat center center;">
        <div class=" h-100">
            <a href="<?php echo $banners_meio['link'] ?? '#'; ?>"><div class="box-slider"></div></a>
        </div>
    </div>
    <div class="row-countdown bg-section bg-banners-m" style="
         background: url('<?php echo base_url('public/upload/banner/' . $banners_meio['banner_mobile']); ?>') no-repeat center center;">
        <div class=" h-100">
            <a href="<?php echo $banners_meio['link'] ?? '#'; ?>"><div class="box-slider"></div></a>
        </div>
    </div>
<?php endif; ?>

<!-- produtos recomendados  -->
<?php if ($produtos_recomendamos) : ?>
    <section class="flat-row main-shop no-padding">
        <div class="">
            <div class="row mx-3">
                <div class="col-md-12">
                    <div class="title-section margin-bottom-50"><h2 class="title">Nós Recomendamos</h2></div>
                    <div class="product-content product-fourcolumn clearfix anime-down">
                        <ul class="product style2 clearfix owl-carousel owl-one owl-theme">
                            <?php foreach ($produtos_recomendamos as $produto) : ?>
                                <li class="product-item ">
                                    <div class="product-thumb clearfix py-0">
                                        <a href="<?php echo base_url($produto['categoria'] . '/' . $produto['subcategoria'] . '/' . $produto['slug']) ?>">
                                            <img class="img-fit" src="<?php echo base_url('/public/upload/produtos/thumb_600/' . $produto['imagem']) ?>" alt="<?php echo $produto['slug']; ?>">
                                        </a>
                                    </div>
                                    <div class="product-info clearfix p-3">
                                        <span class="product-title"><?php echo $produto['nome']; ?></span>
                                        <div class="price">
                                            <ins>
                                                <?php if ($produto['promo'] > '0.00'): ?>
                                                    <span class="amount" style="text-decoration: line-through; font-size: 14px;">R$ <?php echo $produto['preco']; ?></span>
                                                <?php endif; ?>
                                                <span class="amount">R$ <?php echo ($produto['promo'] > '0.00') ? number_format($produto['promo'], 2, ',', '.') : number_format($produto['preco'], 2, ',', '.'); ?></span>
                                            </ins>
                                        </div>
                                        <!--<div class="parcelamento"><span>ou em 10x de R$ 00,00</span></div>-->
                                    </div>
                                    <div class="add-to-cart text-center"><a href="<?php echo base_url($produto['categoria'] . '/' . $produto['subcategoria'] . '/' . $produto['slug']) ?>">Ver Detalhes</a></div>
                                    <!--<a href="produto.html" class="like"><i class="fa fa-heart-o"></i></a>-->
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="divider h56"></div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

<!-- banner promocional 2 -->
<?php if ($banners_baixo) : ?>
    <div class="row-countdown bg-section bg-banners" style="
         background: url('<?php echo base_url('public/upload/banner/' . $banners_baixo['banner']); ?>') no-repeat center center;">
        <div class=" h-100">
            <a href="<?php echo $banners_baixo['link'] ?? '#'; ?>"><div class="box-slider"></div></a>
        </div>
    </div>
    <div class="row-countdown bg-section bg-banners-m" style="
         background: url('<?php echo base_url('public/upload/banner/' . $banners_baixo['banner_mobile']); ?>') no-repeat center center;">
        <div class=" h-100">
            <a href="<?php echo $banners_baixo['link'] ?? '#'; ?>"><div class="box-slider"></div></a>
        </div>
    </div>
<?php endif; ?>

<!-- mais vendidos  -->
<?php if($produtos_vendidos) : ?>
<section class="flat-row main-shop no-padding">
    <div class="">
        <div class="row mx-3">
            <div class="col-md-12">
                <div class="title-section margin-bottom-50"><h2 class="title">Mais Vendidos</h2></div>
                <div class="product-content product-fourcolumn clearfix anime-down">
                    <ul class="product style2 clearfix  owl-carousel owl-one owl-theme">
                        <?php foreach ($produtos_vendidos as $produto) : ?>
                            <li class="product-item ">
                                <div class="product-thumb clearfix py-0">
                                    <a href="<?php echo base_url($produto['categoria'] . '/' . $produto['subcategoria'] . '/' . $produto['slug']) ?>">
                                        <img class="img-fit" src="<?php echo base_url('/public/upload/produtos/thumb_600/' . $produto['imagem']) ?>" alt="<?php echo $produto['slug']; ?>">
                                    </a>
                                </div>
                                <div class="product-info clearfix p-3">
                                    <span class="product-title"><?php echo $produto['nome']; ?></span>
                                    <div class="price">
                                        <ins>
                                            <?php if ($produto['promo'] > '0.00'): ?>
                                                <span class="amount" style="text-decoration: line-through; font-size: 14px;">R$ <?php echo $produto['preco']; ?></span>
                                            <?php endif; ?>
                                            <span class="amount">R$ <?php echo ($produto['promo'] > '0.00') ? number_format($produto['promo'], 2, ',', '.') : number_format($produto['preco'], 2, ',', '.'); ?></span>
                                        </ins>
                                    </div>
                                    <!--<div class="parcelamento"><span>ou em 10x de R$ 00,00</span></div>-->
                                </div>
                                <div class="add-to-cart text-center"><a href="<?php echo base_url($produto['categoria'] . '/' . $produto['subcategoria'] . '/' . $produto['slug']) ?>">Ver Detalhes</a></div>
                                <!--<a href="produto.html" class="like"><i class="fa fa-heart-o"></i></a>-->
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="divider h56"></div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- banners links  -->
<?php if ($banners_baixo_rodape) : ?>
    <section class="row">
        <?php foreach ($banners_baixo_rodape as $bannerBR) : ?>
            <div class="col-md-6 flat-row row-countdown py-5 bg-section anime-down" style="background: url(<?php echo base_url('public/upload/banner/' . $bannerBR['banner']); ?>) no-repeat center center; background-size: cover; height: 700px;">
                <div class="h-100">
                    <div class="row mx-3 h-100">
                        <div class="col-12" style="margin: auto 0;">
                            <div class="flat-content-box clearfix" data-margin="0 0 0 0" data-mobilemargin="0 0 0 0">
                                <div class="flat-countdown-wrap text-center">
                                    <div class="inner" style="background: transparent;">
                                        <h2 class="heading mb-4 font-size-40 line-height-48 text-light"><?php echo $bannerBR['nome']; ?><br></h2>
                                        <p class="desc font-size-18 line-height-48"></p>
                                        <div class="divider h42 clearfix">
                                            <?php if ($bannerBR['link'] != '') : ?>
                                                <a class="themesflat-button has-padding-36 bg-accent has-shadow" href="<?php echo $bannerBR['link']; ?>">Conhecer >>></a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </section>
<?php endif; ?>

<?php echo $this->endSection(); ?>