<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class EnquiryController extends BaseController
{

    public function sendEnquiry()
    {
        $email = \Config\Services::email();
    
        $name = $this->request->getPost('name');
        $emailAddress = $this->request->getPost('email');
        $phone = $this->request->getPost('phone');
        $subject = $this->request->getPost('subject');
        $message = $this->request->getPost('message');
        $productId = $this->request->getPost('product_id');
    
        $db = \Config\Database::connect();
        $builder = $db->table('products'); 
        $builder->select('name');
        $builder->where('id', $productId); 
        $product = $builder->get()->getRow();
    
        if ($product) {
            $productName = $product->name;
        } else {
            $productName = "Unknown Product"; 
        }
    
        $email->setTo('noreply-suntech@techwin.co.ke');
        
        $email->setFrom($emailAddress, $name);
        $email->setSubject($subject);
        $email->setMessage("Product: $productName\nName: $name\nEmail: $emailAddress\nPhone: $phone\n\nMessage:\n$message");
    
        if ($email->send()) {
            return redirect()->back()->with('message', 'Enquiry send successfully');

            // return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error'], 500);
        }
    }
    
    }
    
