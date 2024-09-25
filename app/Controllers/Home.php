<?php

namespace App\Controllers;
use App\Models\ProductModel;
class Home extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();
        
        $data['topDeals'] = $productModel->getTopDeals();
        $data['recommendedProducts'] = $productModel->getRecommendedProducts();
        return view('backend/pages/home/home',$data);
    }
}
