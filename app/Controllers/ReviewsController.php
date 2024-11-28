<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProductModel;
use App\Models\ReviewModel;
class ReviewsController extends BaseController
{

        public function view($productId)
        {
            $productModel = new ProductModel();
            $reviewModel = new ReviewModel();
    
            $data['product'] = $productModel->find($productId);
            $data['reviews'] = $reviewModel->getReviews($productId);
    
            return view('backend/pages/product/view', $data);
        }
    
        public function submitReview()
        {
            if ($this->request->getMethod() === 'post') {
                $reviewModel = new ReviewModel();
    
                $data = [
                    'product_id' => $this->request->getPost('product_id'),
                    'name' => $this->request->getPost('name'),
                    'email' => $this->request->getPost('email'),
                    'phone' => $this->request->getPost('phone'),
                    'text' => $this->request->getPost('text'),
                    'rating' => $this->request->getPost('rating'),
                    'approved' => 0, // Set to 0 for approval needed
                ];
    
                $reviewModel->addReview($data);
                return redirect()->to('/product/view/' . $data['product_id'])->with('message', 'Your review has been submitted and is awaiting approval.');
            }
        }
    }
    
