<?php


namespace App\Repositries\category;
interface CategoryInterface
{
    public function getCategory($request);
    public function getAllCategories();
    public function deleteCategory($id);
    public function findCategoryById($id);
    public function updateOrCreate($request,$id);

    public function getAllCountries();

    public function getAllSliders();
    public function getAllCategoriesWithProducts();

    public function saveCompanyInfo($request);
    public function saveCategory($request);


}
