<?php
/**
 * Created by PhpStorm.
 * User: N8
 * Date: 5/12/2018
 * Time: 3:29 PM
 */

$view->import('partials/header');
?>
    <?php foreach($products as $product): ?>
        <div class="card product-card col-3">
            <img class="card-img-top" src="<?php print($product->image_url); ?>" alt="<?php print($product->name); ?>">
            <div class="card-body">
                <div class="product-description">
                    <h5 class="card-title"><?php print($product->product_name); ?></h5>
                    <p class="card-text"><?php print($product->description); ?></p>
                </div>
                <div class="product-buttons">
                    <a class="btn btn-primary go-to-product float-left" href="/product?id=<?php print($product->id); ?>">Go to</a>
                    <a class="btn btn-warning add-to-cart float-right">Add to cart</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php
$view->import('partials/footer');