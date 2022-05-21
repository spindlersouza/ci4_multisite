<section class="flat-row mail-chimp anime">
    <div class="">
        <div class="row mx-3">
            <div class="col-md-6">
                <div class="text">
                    <h3>Receba nossas novidades</h3>
                    <?php echo $news['texto']; ?>
                </div>
            </div>
            <div class="col-md-6">
                <form class="w-100" action="#" method="post" id="subscribe-form">
                    <div class="subscribe clearfix">
                        <div class="row d-flex justify-content-end subscribe-content">
                            <div class="col-12 col-lg-4 px-0 my-1 my-lg-0 mx-1 input border-btn">
                                <input type="hidden" name="site_id" value="<?php echo SITEENABLED ?>" />
                                <input type="text" name="nome" placeholder="Seu nome">
                            </div>
                            <div class="col-12 col-lg-4 px-0 my-1 my-lg-0 mx-1 input border-btn">
                                <input type="text" name="email" placeholder="Seu Email">
                            </div>
                            <div class="col-6 col-lg-2 px-0 my-1 my-lg-0 mx-1 button border-btn" style="height: 51px;">
                                <button class="w-100 h-100 p-0 text-black" type="button" id="cadNews">ENVIAR</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
