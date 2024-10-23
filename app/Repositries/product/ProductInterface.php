<?php


namespace App\Repositries\product;
interface ProductInterface
{
    public function getProduct($request);
    public function getAllProduct();
    public function deleteProduct($id);
    public function findProductById($id);
    public function updateOrCreate($request,$id);
    public function getAllProductWithPaginate();


}
