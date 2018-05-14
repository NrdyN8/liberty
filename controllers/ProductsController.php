<?php
/**
 * Created by PhpStorm.
 * User: N8
 * Date: 5/12/2018
 * Time: 1:23 PM
 */

require_once('./models/product.php');

class ProductsController extends Controller {

    public function index(Request $request) {
        return new View('productsHome', ["products"=>Product::all()]);
    }

}