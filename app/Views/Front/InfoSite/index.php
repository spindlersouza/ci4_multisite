<?php echo $this->extend('front'); ?>
<?php echo $this->section('content'); ?>
  <div class="slider-banner"></div>
        <div class="page-title parallax" style="background-image: url(../images/parallax/bg-parallax1.jpg);">
            <div class="">
                <div class="row mx-3">
                    <div class="col-md-12">
                        <div class="page-title-heading">
                            <h1 class="title"><?php echo $labelPolitica; ?></h1>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <section class="py-4">
            <div class="">
                <div class="row mx-3">
                    <div class="col-12">
                        <p><?php echo ${$politica}[0][$politica]; ?></p>
                    </div>
                </div>
            </div>
        </section>

<?php echo $this->endSection(); ?>
