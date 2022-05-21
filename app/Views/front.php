<!DOCTYPE html>
<html lang="en">
    <?php echo $this->include('Front/_head'); ?>
    <body class="header_sticky header-style-2 header-absolute header-center has-menu-extra">
        <div class="boxed">
            <div id="site-header-wrap" class="menu-top-bg">
                <?php echo $this->include('Front/_topo'); ?>
                <?php echo $this->include('Front/_menu_' . $site); ?>
            </div>
            <?php echo $this->renderSection('content'); ?>
            <?php echo $this->include('Front/_newsletter'); ?>
            <?php echo $this->include('Front/_rodape'); ?>
            <?php echo $this->include('Front/_footer'); ?>
            <?php echo $this->include('Front/_copyright'); ?>
        </div>

    </body>
</html>
