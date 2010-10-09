<?php echo $this->doctype(); ?>
<html>
<head>
<?php echo $this->headTitle() ?>
<?php echo $this->headMeta() ?>
<?php echo $this->headLink() ?>
<?php echo $this->headScript() ?>
</head>
<body>
<!-- header -->
    <div id="header">
            <!-- logo -->
            <div id="logo">
                    <h1><a href="" title="Smooth Admin"><img src="images/logo.png" alt="Smooth Admin" /></a></h1>
            </div>
            <!-- end logo -->
            
            <!-- user -->
                <?php echo $this->LogoutLink() ?>
            <!-- end user -->
            
            <div id="header-inner">
                    <div id="home">
                            <a href="/admin"></a>
                    </div>
                    <!-- quick -->
                    <?php
                        //Zend_Debug::dump( APPLICATION_PATH );die();
                       $this->navigation()->menu()->setPartial( array( 'elements/menu1.inc', 'default' ) );
                       echo $this->navigation()->menu()->render();
                    ?>
                    <!-- end quick -->
                    <div class="corner tl"></div>
                    <div class="corner tr"></div>
            </div>
    </div>
<!-- end header -->
<!-- content -->
<div id="content">
    <div class="box <?php echo $this->placeholder('additionalclass') ?>">
        <div class="title">
            <?php
                $this->placeholder('title')
                     ->setPrefix('<h5>')
                     ->setPostfix('</h5>');
                echo $this->placeholder('title');
                echo $this->placeholder('links');
            ?>
        </div>
<?php 
    $errorMessage = $this->flashMessage();
    echo !empty( $errorMessage ) ? "<div class='messages'>{$errorMessage}</div>" : '';
    echo $this->layout()->content;
?>
    </div>
</div>	
</body>
<?php echo $this->inlineScript() ?>
</html>	