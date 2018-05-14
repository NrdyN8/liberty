<?php
$view->import('partials/header');
?>
    <h1>
        ERROR 403: Unauthorized
    </h1>
    <?php if(isset($error)): ?>
        <h2><?php print($error["message"]); ?></h2>
    <?php endif;?>
<?php
$view->import('partials/footer');