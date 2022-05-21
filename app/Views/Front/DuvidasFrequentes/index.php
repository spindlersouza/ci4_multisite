<?php echo $this->extend('front'); ?>
<?php echo $this->section('content'); ?>

<!-- banner topo  -->
<div class="slider-banner"></div>
<div class="page-title parallax" style="background-image: url('<?php echo base_url('public/upload/banner/' . $paginas['banner']); ?>');">
    <div class="">
        <div class="row mx-3">
            <div class="col-md-12">
                <div class="page-title-heading"><h1 class="title">Dúvidas Frequentes</h1></div>
                <?php echo $paginas['texto']; ?>
            </div>
        </div>
    </div>
</div>

<!-- conteúdo  -->
<section class="py-4">
    <div class="">
        <div class="row mx-3">
            <div class="col-12">
                <p>
                    <?php foreach ($duvidas as $duvida) : ?>
                        <b><?php echo $duvida['duvida']; ?></b>
                        <br> 
                        <?php echo $duvida['resposta']; ?>
                        <br><br>
                    <?php endforeach; ?>
                </p>
            </div>
        </div>
    </div>
</section>

<?php echo $this->endSection(); ?>
