<head>
    <meta charset="utf-8" />
    <title> Instinto Íntimo <?php echo ' - ' . ucfirst($site) ?? ''; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <?php if (isset($produto)) : ?>
        <meta property="og:type" content="product" />
        <meta property="og:title" content="<?php echo $produto['nome']; ?>| Instinto Intimo" />
        <meta property="og:description" content="<?php echo $produto['descricao']; ?>" />
        <meta property="product:sku" content="<?php echo $produto['referencia']; ?>" />
        <meta property="product:condition" content="new" />
        <meta property="product:brand" content="Instinto Intimo" />
        <meta property="product:retailer_item_id" content="<?php echo $produto['referencia']; ?>" />
        <meta property="product:price:currency" content="BRL" />
        <meta property="og:image" content="<?php echo base_url('public/upload/produtos/thumb_600/' . $produto['imagem']); ?>" />
        <?php if ($galeria) : ?>
            <?php foreach ($galeria as $gimg) : ?>
                <meta property="og:image" content="<?php echo base_url('public/upload/produtos/thumb_600/' . $gimg['imagem']); ?>" />
            <?php endforeach; ?>
        <?php endif; ?>
        <meta property="product:availability" content="instock" />
        <meta property="product:price:amount" content="<?php echo ($produto['promo'] != '0.00') ? number_format($produto['promo'], 2, ',', '.') : number_format($produto['preco'], 2, ',', '.'); ?>" />
        <meta property="og:url" content="<?php echo base_url($produto['categoria'] . '/' . $produto['subcategoria'] . '/' . $produto['slug']) ?>" />

    <?php endif; ?>
    <link rel="stylesheet" href="<?php echo base_url('public/Front/assets/css/bootstrap.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('public/Front/assets/css/bootstrap4.6.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('public/Front/assets/css/style.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('public/Front/assets/css/responsive.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('public/Front/assets/plugins/owlcarousel/assets/owl.carousel.min.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('public/Front/assets/js/light-gallery/lightgallery.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('public/Front/assets/js/light-gallery/flaticon.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('public/Front/assets/plugins/owlcarousel/assets/owl.theme.default.min.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('public/Front/assets/css/custom_' . ($site ?? '') . '.css'); ?>"/>
    <link href="<?php echo base_url('public/Front/assets/img/favicon.png'); ?>" rel="shortcut icon" />
</head>


