<?php echo $this->extend('front'); ?>
<?php echo $this->section('content'); ?>
<!-- banner topo  -->
<div class="slider-banner"></div>
<!-- <div class="page-title parallax" style="background-image: url(../<?php echo base_url('public/Front/assets/img/parallax/bg-parallax1.jpg'); ?>">
    <div class="">
        <div class="row mx-3">
            <div class="col-md-12">
                <div class="page-title-heading">
                    <h1> Nome da categoria</h1>
                </div>

            </div>
        </div>
    </div>
</div> -->

<!-- categoria  -->
<style type="text/css">
    .product.style2 .product-item {
        width: auto !important;
    }
    .product .product-item .add-to-cart {
        top: 0px !important;
    }
</style>
<section class="flat-row main-shop shop-4col py-3">
    <div class="pt-md-5">
        <div class="row mx-3">
            <div class="col-md-12">
                <div class="product-content product-fourcolumn clearfix">
                    <ul class="product style2 row d-flex justify-content-start">
                        <?php foreach ($produtos as $produto) : ?>
                            <li class="product-item col-12 col-md-4 col-lg-3 ">
                                <div class="product-thumb clearfix py-3">
                                    <a href="<?php echo base_url($produto['categoria'] . '/' . $produto['subcategoria'] . '/' . $produto['slug']) ?>">
                                        <img class="img-fit" src="<?php echo base_url('/public/upload/produtos/thumb_600/' . $produto['imagem']) ?>" alt="<?php echo $produto['slug']; ?>">
                                    </a>
                                </div>
                                <div class="product-info clearfix p-3">
                                    <span class="product-title"><?php echo $produto['nome']; ?></span>
                                    <div class="price">
                                        <ins>
                                            <?php if ($produto['promo'] > '0.00') : ?>
                                                <span class="amount" style="text-decoration: line-through; font-size: 14px;">R$ <?php echo $produto['preco']; ?></span>
                                            <?php endif; ?>
                                            <span class="amount">R$ <?php echo ($produto['promo'] > '0.00') ? number_format($produto['promo'], 2, ',', '.') :  number_format($produto['preco'], 2, ',', '.'); ?></span>
                                        </ins>
                                    </div>
                                    <?php if (1 == 2) : ?>
                                        <div class="parcelamento"><span>ou em 10x de R$ 00,00</span></div>
                                    <?php endif; ?>
                                </div>
                                <div class="add-to-cart text-center"><a href="<?php echo base_url($produto['categoria'] . '/' . $produto['subcategoria'] . '/' . $produto['slug']) ?>">Ver Detalhes</a></div>
                                <?php if (1 == 2) : ?>
                                    <a href="<?php echo base_url($produto['categoria'] . '/' . $produto['subcategoria'] . '/' . $produto['slug']) ?>" class="like"><i class="fa fa-heart-o"></i></a>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php if (1 == 2) : ?>
                    <div class="product-pagination text-center margin-top-11 clearfix">
                        <ul class="flat-pagination">
                            <li class="prev">
                                <a href="#"><i class="fa fa-angle-left"></i></a>
                            </li>
                            <li><a href="#">1</a></li>
                            <li class="active"><a href="#" title="">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#"><i class="fa fa-angle-right"></i></a></li>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php echo $this->endSection(); ?>