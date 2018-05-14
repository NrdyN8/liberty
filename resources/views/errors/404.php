<?php
$view->import('partials/header');
?>
    <h1>
        ERROR 404: Page not found
    </h1>
    <?php if(isset($error)): ?>
        <h2><?php print($error);?></h2>
    <?php endif;?>
<?php
$view->import('partials/footer');