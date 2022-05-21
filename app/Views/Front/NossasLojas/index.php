<?php echo $this->extend('front'); ?>
<?php echo $this->section('content'); ?>
<!-- banner topo  -->
<div class="slider-banner"></div>
<div class="page-title parallax" style="background-image: url('<?php echo base_url('public/upload/banner/' . $paginas['banner']); ?>');">
    <div class="">
        <div class="row mx-3">
            <div class="col-md-12">
                <div class="page-title-heading"><h1 class="title">Nossas Lojas</h1></div>
                <?php echo $paginas['texto']; ?>
            </div>
        </div>
    </div>
</div>
<section class="py-4">
    <div class="">
        <div class="row mx-3">
            <div class="col-12">
                <table class="w-100 py-0" style="font-size: .7rem;">
                    <thead class="border-bottom">
                        <tr>
                                <th> <b>UF</b> </th>
                                <th> <b>Cidade</b> </th>
                                <th> <b>Localização</b> </th>
                                <th class="text-center"> <b>Telefone</b> </th>
                                <th class="text-right"> <b>Whatsapp</b> </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lojas as $loja) : ?>
                            <tr class="py-3 border-bottom" style="line-height: 40px !important;" >
                                <td><?php echo $loja['uf']; ?></td>
                                <td><?php echo $loja['cidade']; ?></td>
                                <td><?php echo $loja['localizacao']; ?></td>
                                <td class="text-center"><i class="fa fa-phone"></i>&nbsp;<?php echo $loja['telefone']; ?></td>
                                <td class="text-right"><a href="#"><i class="fa fa-whatsapp"></i>&nbsp;<?php echo $loja['whatsapp']; ?></a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<?php echo $this->endSection(); ?>