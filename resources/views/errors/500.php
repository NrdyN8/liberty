<?php
$view->import('partials/header');
?>
    <h1>
        ERROR 500: Something went wrong on the server
    </h1>
    <?php if(isset($error)): ?>
        <h2><?php print($error); ?></h2>
    <?php endif;?>
<?php
$view->import('partials/footer');