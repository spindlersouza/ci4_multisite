<?php echo $this->extend('admin'); ?>
<?php echo $this->section('content'); ?>
<span data-active="news"></span>
<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header">News</h2>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('admin/dashboard') ?>">Home</a></li>
            <li class="active">Newsletter</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-left">Nome</th>
                        <th class="text-left">Email</th>
                        <th class="text-left">Site</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($news as $result) : ?>
                        <tr>
                            <td class="text-left"><?php echo $result['nome']; ?> </td>
                            <td class="text-left"><?php echo $result['email']; ?> </td>
                            <td class="text-left"><?php echo $result['site']; ?> </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php echo $this->endSection(); ?>
