<?php echo $this->extend('front'); ?>
<?php echo $this->section('content'); ?>
<!-- banner topo  -->
<div class="slider-banner"></div>
<!-- produto  -->

<style>
    .alerta {
        padding: 10px 0;
        background: #9ac6d3;
        color: #fff;
        font-size: 18px;
        margin: 10px 0;
        text-align: center;
    }

    .product-detail .add-to-cart a {
        background-color: #5f9cb9;
    }
    .add_carrinho {
        position: fixed;
        top: 250px;
        background: #70b1cf;
        padding: 20px;
        z-index: 9999;
        width: 380px;
        left: 40vw;
        border-radius: 10px;
        text-align: center;
        box-shadow: 2px 2px 10px;
    }

    .add_carrinho a {
        position: relative;
        top: -17px;
        overflow: hidden;
        right: -177px;
        background: #dddddd47;
        border-radius: 0 10px 0 10px;
    }

    @media (max-width: 772px) {
        .add_carrinho {
            left: 10vw;
            width: 300px;
        }

        .add_carrinho a {
            top: -16px;
            overflow: hidden;
            right: -137px;
        }

    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        opacity: 1;
    }
</style>
<section class="flat-row main-shop shop-detail style-1 pt-5 pb-2">
    <div class="px-lg-0">
        <div class="row mx-3 d-flex justify-content-md-between">
            <div class="col-xl-6 row mx-0 col-product">
                <div class="col-12 col-lg-12 p-0 ">
                    <div class=" clearfix">
                        <div class="style-2 has-relative">
                            <div class="owl-carousel owl-produtos owl-theme image-gallery">
                                <?php if ($produto['video'] != '') : ?>
                                    <div class="gallery-icon portrait text-center">
                                        <video width="100%" height="640" controls autoplay>
                                            <source src="<?php echo base_url('public/upload/produtos/video/' . $produto['video']); ?>" type="video/mp4">
                                        </video>
                                    </div>
                                <?php endif; ?>
                                <?php foreach ($galeria as $gimg) : ?>
                                    <div class="gallery-icon portrait text-center galeria_produto" data-cor="<?php echo $gimg['cor']; ?>">
                                        <!--<a href="<?php echo base_url('public/upload/produtos/thumb_1200/' . $gimg['imagem']); ?>">-->

                                        <img class="img-fit-gallery" data-izoomify-url="<?php echo base_url('public/upload/produtos/thumb_1200/' . $gimg['imagem']); ?>" data-izoomify-magnify="2.75" data-izoomify-duration="300" src="<?php echo base_url('public/upload/produtos/thumb_1200/' . $gimg['imagem']); ?>" alt="">
                                        <!--</a>-->
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div id="aux_slider" class="d-none">
                                <?php if ($produto['video'] != '') : ?>
                                    <div class="gallery-icon portrait text-center">
                                        <video width="100%" height="640" controls autoplay>
                                            <source src="<?php echo base_url('public/upload/produtos/video/' . $produto['video']); ?>" type="video/mp4">
                                        </video>
                                    </div>
                                <?php endif; ?>
                                <?php foreach ($galeria as $gimg) : ?>
                                    <div class="gallery-icon portrait text-center galeria_produto" data-cor="<?php echo $gimg['cor']; ?>">
                                        <a href="<?php echo base_url('public/upload/produtos/thumb_1200/' . $gimg['imagem']); ?>">
                                            <img class="img-fit-gallery" data-izoomify-url="<?php echo base_url('public/upload/produtos/thumb_1200/' . $gimg['imagem']); ?>" data-izoomify-magnify="2.75" data-izoomify-duration="300" src="<?php echo base_url('public/upload/produtos/thumb_1200/' . $gimg['imagem']); ?>" alt="">
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 p-0 pl-lg-2 col-product">
                <div class="divider h0"></div>
                <div class="product-detail clearfix">
                    <div class="px-3">
                        <div class="content-detail py-0">
                            <div class="row p-0 m-0">
                                <div class="col-12 col-md-8 pl-0 pr-2 m-0">
                                    <h2 class="product-title"><?php echo $produto['nome']; ?></h2>
                                    <span><?php echo $produto['ncategoria'] . ' - ' . $produto['nsubcategoria']; ?> | Ref: <?php echo $produto['referencia']; ?></span>
                                    <!--<div class="flat-star style-1 my-1"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-half-o"></i><i class="fa fa-star-half-o"></i><span>(19)</span></div>-->
                                </div>

                                <div class="col-12 col-md-4 p-0 m-0">
                                    <span>Compartilhe:</span>
                                    <ul class="flat-socials my-0">
                                        <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo base_url($produto['categoria'] . '/' . $produto['subcategoria'] . '/' . $produto['slug']); ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                        <li><a href="https://twitter.com/share?url=<?php echo base_url($produto['categoria'] . '/' . $produto['subcategoria'] . '/' . $produto['slug']); ?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo base_url($produto['categoria'] . '/' . $produto['subcategoria'] . '/' . $produto['slug']); ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                                        <li><a href="https://api.whatsapp.com/send?1=pt_BR&text=<?php echo base_url($produto['categoria'] . '/' . $produto['subcategoria'] . '/' . $produto['slug']); ?>" target="_blank"><i class="fa fa-whatsapp"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12"><p><?php echo $produto['descricao_simplificada']; ?></p></div>
                                <form action="" class="col-12 px-3">
                                    <div class="col-12 px-0 my-2 widget widget-color w-100">
                                        <hr class="my-1">
                                        <?php if ($atributos['CORES']) : ?>
                                            <h5 class="widget-title my-1">Cores disponíveis:</h5>
                                            <ul class="flat-color-list icon-left p-0 row" style="display: flex;align-items: center;">
                                                <input type="hidden" id="cor_unica_selecionada" value="<?php echo $cor_unica; ?>">
                                                <input type="hidden" id="tamanho_unico_selecionado" value="<?php echo $tamanho_unico; ?>">
                                                <input type="hidden" id="cor_selecionada" value="<?php echo $cor_unica; ?>">
                                                <input type="hidden" id="tamanho_selecionado" value="<?php echo $tamanho_unico; ?>">
                                                <?php foreach ($atributos['CORES'] as $cor) : ?>
                                                    <?php if ($cor['imagem'] == '') : ?>
                                                        <li class="col-1 m-0 p-0 clickcor" data-cor="<?php echo $cor['id']; ?>" style="display: flex;align-items: center;" data-corvl="<?php echo $cor['valor']; ?>">
                                                            <a href="javascript:void(0)" class="cor_<?php echo $cor['valor']; ?> "></a>
                                                        </li>
                                                    <?php else : ?>
                                                        <li class="col-1 m-0 p-0 clickcor" data-cor="<?php echo $cor['id']; ?>" style="display: flex;align-items: center;" data-corvl="<?php echo $cor['valor']; ?>">
                                                            <a href="javascript:void(0)"><img class="" src="<?php echo base_url('public/upload/produtos/cores/' . $cor['imagem']); ?>" alt="" style="width: 30px;"></a>
                                                        </li>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>
                                        <div id="produto_cor_valida" style="display:none;" class="col-12 col-md-6 alerta">Selecione uma cor!</div>
                                    </div>
                                    <div class="col-12  px-0 my-2 widget widget-size w-100 row">
                                        <hr class="my-1">
                                        <?php if ($atributos['TAMANHOS']) : ?>
                                            <h5 class="col-12 widget-title my-1 d-flex justify-content-between">Tamanhos: </h5>
                                            <ul class="col-12 col-md-8 px-md-3" style="display: flex;">
                                                <?php foreach ($atributos['TAMANHOS'] as $tam) : ?>
                                                    <li class="box-tamanho center-center clicktamanho" data-tamanho="<?php echo $tam['id']; ?>">
                                                        <a href="javascript:void(0)" class="w-100 <?php echo ($tamanho_unico != '') ? 'tamanho_active' : '' ?> "><?php echo $tam['valor']; ?></a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>
                                    </div>
                                    <div id="produto_tamanho_valida" style="display:none;" class="col-12 col-md-6 alerta">Selecione um tamanho!</div>
                                    <?php if ($produto['ncategoria'] != 'ACESSORIOS') : ?>
                                        <div class="col-12 p-0">
                                            <button class="col-8 col-md-7 box-medida" type="button" data-toggle="modal" data-target="#medidaModal">Encontre sua medida:</button>
                                        </div>
                                    <?php endif; ?>

                                </form>
                            </div>
                            <div class="price">
                                <?php if ($produto['promo'] != '0.00') : ?>
                                    <del class="p-0"><span class="regular">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></span></del><br>
                                <?php endif; ?>
                                <ins class="p-0"><span class="amount">R$ <?php echo ($produto['promo'] != '0.00') ? number_format($produto['promo'], 2, ',', '.') : number_format($produto['preco'], 2, ',', '.'); ?></span></ins>
                            </div>
                            <div class="product-quantity m-0 my-2 d-md-flex justify-content-between">
                                <div class="num-block skin-2 my-1 mx-0">
                                    <div class="num-in">
                                        <span id="minus_produto" class="minus dis"></span>
                                        <input type="text" id="produto_quantidade" class="in-num" value="1" readonly="">
                                        <span id="plus_produto" class="plus"></span>
                                    </div>
                                </div>
                                <div class=" add-to-cart my-1 px-2 text-center" style="width: 225px;">
                                    <a id="addProduto" data-idProduto="<?php echo $produto['id']; ?>">COMPRAR</a>
                                </div>

                                <!-- alerta adicionado ao carrinho -->
                                <div id="AddCarrinho" class="add_carrinho anime-down" style="display:none;">
                                    <a class="text-light p-2" href="javascript:void(0);" onclick="AddCarrinhoClose()"> <span>X</span></a>
                                    <h5 class="text-light">Produto adicionado ao carrinho!</h5>
                                </div>


                                <div class=" box-like my-1 margin-left-3">
                                    <a href="javascript:void(0);" class="like <?php echo ($favorito) ? 'delfavorito' : 'addfavorito'; ?>" data-id="<?php echo $produto['id'] ?>" style="<?php echo ($favorito) ? 'color:red' : ''; ?>"><i class="fa fa-heart-o"></i></a>
                                </div>
                                <div class=" box-like my-1 margin-left-3">
                                    <a href="https://api.whatsapp.com/send?phone=5505499266-9406&text=Olá,%20tenho%20interesse%20no%20produto:%20<?php echo $produto['nome']; ?>%20|%20Valor:%20R$%20<?php echo ($produto['promo'] != '0.00') ? number_format($produtos['promo'], 2, ',', '.') : number_format($produto['preco'], 2, ',', '.'); ?>" target="_blank" style=" font-size: 14px;"><i class="fa fa-whatsapp"></i>&nbsp;Compre pelo whatsapp</a>
                                </div>
                            </div>
                            <div class="product-quantity m-0 border-btn my-2 p-2">
                                <div class="w-100 px-3">
                                    <p class="text-uppercase">
                                        <b>Calcule o frete deste produto para a sua localidade: &emsp;
                                        </b>
                                    </p>
                                </div>
                                <div class="row center-center px-3 px-md-0">
                                    <div class="col-12 col-md-3 box-like my-1 px-2 margin-left-3"><label class="pt-2" for="" style="font-size: 12px; color: #000; font-weight: 400;">INFORME SEU CEP:</label></div>
                                    <div class="col-12 col-md-6 box-like my-1 margin-left-3" style="font-size: 12px;"><input type="text" id="cepProduto" class="cep-mask" /></div>
                                    <div class="col-11 col-md-2 button border-btn my-1 p-0 margin-left-3" style="font-size: 12px; height: 50px;">
                                        <button class="w-100 h-100 p-0 text-black" type="button" data-produto="<?php echo $produto['id'] ?>" id="calcularFreteProduto" style="font-size: 12px;">Calcular</button>
                                    </div>

                                </div>
                                <!-- resposta frete -->
                                <div class="row center-center mx-1 my-3" id="valorCepProduto" style="color: #505050; background: #dddddd4f;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- detalhes do produto  -->
<section class="px-3">
    <div class="inner p-5"><?php echo $produto['descricao']; ?></div>
</section>

<!-- avaliação  -->
<section class="px-3">
    <div class="title-section my-4">
        <h2 class="title">Avaliações</h2>
    </div>
    <div class="inner py-2">
        <div class="row text-center my-4">
            <div class="col-12">
                <h1><b><?php echo $produto_nota; ?> <span style="font-size: 16px;">/5</span></b></h1>
                <span>Nota do Produto</span><br>
                <div class="flat-star style-1 my-1">
                    <i class="fa fa-star<?php echo $produto_avaliacao['1']; ?>"></i>
                    <i class="fa fa-star<?php echo $produto_avaliacao['2']; ?>"></i>
                    <i class="fa fa-star<?php echo $produto_avaliacao['3']; ?>"></i>
                    <i class="fa fa-star<?php echo $produto_avaliacao['4']; ?>"></i>
                    <i class="fa fa-star<?php echo $produto_avaliacao['5']; ?>"></i>
                    <span>(<?php echo $produto_notas; ?>)</span>
                </div>
            </div>
        </div>
        <?php if ($avaliacoes) : ?>
            <ul class="row d-flex justify-content-center">
                <?php foreach ($avaliacoes as $avaliacao) : ?>
                    <li class="col-10 col-md-8 px-3 mb-4 border border-gray row">
                        <div class="col-3 p-2">
                            <?php if ($avaliacao['imagem'] == '') : ?>
                                <img src="<?php echo base_url('public/Front/assets/img/avatar-unknown.png'); ?>" alt="Image" style="border-radius: 50%; width: 170px;">
                            <?php else : ?>
                                <img src="<?php echo base_url('public/upload/clientes/' . $avaliacao['imagem']); ?>" alt="Image">
                            <?php endif; ?>
                        </div>
                        <div class="col-9 text-wrap py-3">
                            <div class="review-meta">
                                <h5 class="name"><?php echo $avaliacao['nome']; ?></h5>
                                <div class="flat-star style-1">
                                    <i class="fa fa-star<?php echo $avaliacao['nota']['1']; ?>"></i>
                                    <i class="fa fa-star<?php echo $avaliacao['nota']['2']; ?>"></i>
                                    <i class="fa fa-star<?php echo $avaliacao['nota']['3']; ?>"></i>
                                    <i class="fa fa-star<?php echo $avaliacao['nota']['4']; ?>"></i>
                                    <i class="fa fa-star<?php echo $avaliacao['nota']['5']; ?>"></i>
                                </div>
                            </div>
                            <div class="review-text">
                                <p><?php echo $avaliacao['descricao']; ?></p>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <?php if (session('cliente_id')) : ?>
            <div class="row d-flex justify-content-center">
                <div class="col-10 col-md-8 my-4 text-center">
                    <h5> <b>Deixe sua avaliação</b></h5>
                </div>
                <form class="col-10 col-md-8 px-0 " id="commentform" method="post" action="#">
                    <input type="hidden" id="nota" name="nota" value="" />
                    <input type="hidden" id="produtoAval" value="<?php echo $produto['id']; ?>" />
                    <p id="starAvaliacao" class="flat-star style-1">
                        <label>Nota*:</label>
                        <i class="fa fa-star-o starAval" data-v="1" ></i>
                        <i class="fa fa-star-o starAval" data-v="2" ></i>
                        <i class="fa fa-star-o starAval" data-v="3" ></i>
                        <i class="fa fa-star-o starAval" data-v="4" ></i>
                        <i class="fa fa-star-o starAval" data-v="5" ></i>
                    </p>
                    <p class="comment-form-comment">
                        <label>Comentário*</label>
                        <textarea class="" tabindex="4" id="comentAval" name="comment" required> </textarea>
                    </p>
                    <p class="comment-name">
                        <label>Nome*</label>
                        <input type="text" aria-required="true" size="30" value="<?php echo session('cliente_nome'); ?>" name="name" id="name" disabled>
                    </p>
                    <p class="comment-email">
                        <label>Email*</label>
                        <input type="email" size="30" value="<?php echo session('cliente_email'); ?>" name="email" id="email" disabled>
                    </p>
                    <p class="my-3">
                        <button id="btnAval" type="button" class="btn btn-secondary rounded-0">Avaliar</button>
                    </p>
                </form>
            </div>
        <?php endif; ?>

    </div>

</section>
<!-- produtos relacionados  -->
<?php if ($produtos_relacionados) : ?>
    <section class="flat-row main-shop ">
        <div class="pt-5">
            <div class="row mx-3">
                <div class="col-md-12">
                    <div class="title-section margin-bottom-50"><h2 class="title">Você pode gostar também</h2></div>
                    <div class="product-content product-fourcolumn clearfix anime-down">
                        <ul class="product style2 clearfix owl-carousel owl-one owl-theme">
                            <?php foreach ($produtos_relacionados as $produto) : ?>
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
                                                <?php if ($produto['promo'] > '0.00') : ?>
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
                    <!-- <div class="divider h56"></div> -->
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
<!-- Modal -->
<div class="modal fade" id="medidaModal" tabindex="-1" aria-labelledby="medidaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="medidaModalLabel">Encontre sua medida</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="modal-body p-0">
                    <?php if ($produto['ncategoria'] == 'LEGGING') : ?>
                        <img class="m-0" src="<?php echo base_url('public/Front/assets/img/medida_legging.jpg'); ?>" alt="image">
                    <?php endif; ?>
                    <?php if ($produto['ncategoria'] == 'SHORT') : ?>
                        <img class="m-0" src="<?php echo base_url('public/Front/assets/img/medida_short.jpg'); ?>" alt="image">
                    <?php endif; ?>
                    <?php if ($produto['ncategoria'] == 'BLUSAS E CASACOS') : ?>
                        <img class="m-0" src="<?php echo base_url('public/Front/assets/img/medida_casacos.jpg'); ?>" alt="image">                           
                    <?php endif; ?>
                    <?php if ($produto['ncategoria'] == 'TOP') : ?>
                        <img class="m-0" src="<?php echo base_url('public/Front/assets/img/medida_top.jpg'); ?>" alt="image">                           
                    <?php endif; ?>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    //ESTÀ DANDO ERRO DE JS
    //    $(window).on('scroll', function () {
    //        if ($(window).scrollTop() > 750) {
    //            $('.product-details').attr('style', 'display: none;');
    //        } else {
    //            $('.product-details').attr('style', 'display: block;');
    //        }
    //    });
</script>

<script>
    function AddCarrinhoClose() {
        document.getElementById("AddCarrinho").style.display = "none";
    }
</script>
<?php echo $this->endSection(); ?>