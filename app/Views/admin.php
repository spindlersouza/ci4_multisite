<!DOCTYPE html>
<html lang="en">
    <?php echo $this->include('Back/_head'); ?>
    <body>
        <?php //verify session ?>
        <div id="wrapper">        
            <?php echo $this->include('Back/_menu'); ?>
            <div id="page-wrapper">
                <div class="container-fluid">   
                    <?php echo $this->renderSection('content'); ?>
                </div>
            </div>
            <?php echo $this->include('Back/_footer'); ?>
    </body>
</html>
