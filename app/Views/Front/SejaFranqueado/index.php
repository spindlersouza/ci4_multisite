<?php echo $this->extend('front'); ?>
<?php echo $this->section('content'); ?>
        
        <!-- conteúdo -->
        <section class="py-5 border-top slider-banner">
            <div class="">
                <div class="row mx-3 mb-5">
                    <div class="col-md-6" style="margin: auto 0;">
                        <h1>SEJA UM FRANQUEADO</h1>
                        <p class="my-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam malesuada orci non eros suscipit, et lacinia ligula pulvinar. In suscipit velit mattis mauris ultricies gravida. Suspendisse potenti. Sed auctor libero sed orci faucibus
                            iaculis. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.
                        </p>
                        <div class="button">
                            <button class="border-btn text-black" type="button" data-toggle="modal" data-target="#Modal-Form">Tenho Interesse</button>
                        </div>

                    </div>
                    <div class="col-md-6 px-md-0">
                        <img class="w-100 my-3" src="images/parallax/bg-parallax7.jpg" alt="image" style="object-fit: cover; min-height: 500px;">
                    </div>
                </div>
            </div>
        </section>

        <!-- Modal -->
        <div class="modal fade" id="Modal-Form" tabindex="-1" aria-labelledby="Modal-FormLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content rounded-0">
                    <div class="modal-header">
                        <h5 class="modal-title" id="Modal-FormLabel">Seja um Franqueado</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="wrap-contact style2">
                            <form novalidate="" class="contact-form" id="contactform" method="post" action="#">
                                <div class="form-text-wrap clearfix">
                                    <div class="contact-name">
                                        <label></label>
                                        <input type="text" placeholder="Nome" aria-required="true" size="30" value="" name="nome" id="author">
                                    </div>
                                    <div class="contact-email">
                                        <label></label>
                                        <input type="email" size="30" placeholder="Email" value="" name="email" id="email">
                                    </div>
                                    <div class="contact-name">
                                        <label></label>
                                        <input type="text" size="30" placeholder="Telefone/Whatsapp" value="" name="telefone" id="email">
                                    </div>
                                    <div class="contact-name">
                                        <label></label>
                                        <input class="file_customizada w-100" type="file" size="30" name="arquivos[]" style="border-bottom: 1px solid #ebebeb">
                                    </div>

                                </div>
                                <div class="contact-message clearfix">
                                    <label></label>
                                    <textarea class="" tabindex="4" placeholder="Mensagem" name="mensagem" required></textarea>
                                </div>
                                <div class="form-submit">
                                    <button class="themesflat-button bg-accent has-shadow">ENVIAR</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal" style="font-size: 14px;">Fechar</button>
                    </div>
                </div>
            </div>
        </div>

        <?php echo $this->endSection(); ?>