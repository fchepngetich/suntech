<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\FaqModel;
use App\Libraries\CIAuth;

class FaqController extends BaseController
{
        protected $faqModel;
    
        public function __construct()
        {
            $this->faqModel = new FaqModel();
        }
    
        // Display the list of FAQs
        public function index()
        {
            $full_name =CIAuth::id();
        $data['full_name'] = $full_name;
            $data['faqs'] = $this->faqModel->findAll();
            return view('admin/pages/faqs/index', $data);
        }
    
        // Show the form to create a new FAQ
        public function create()
        {
            $full_name =CIAuth::id();
        $data['full_name'] = $full_name;
            return view('admin/pages/faqs/create',$data);
        }
    
        // Store a new FAQ
        public function store()
        {
            $this->faqModel->save([
                'name' => $this->request->getPost('name'),
                'description' => $this->request->getPost('description'),
            ]);
            return redirect()->to(base_url().'admin/faqs');
        }
    
        // Show the form to edit an FAQ
        public function edit($id)
        {
            $full_name =CIAuth::id();
            $data['full_name'] = $full_name;
            $data['faq'] = $this->faqModel->find($id);
            return view('admin/pages/faqs/edit', $data);
        }
    
        // Update an FAQ
        public function update($id)
        {
            $this->faqModel->update($id, [
                'name' => $this->request->getPost('name'),
                'description' => $this->request->getPost('description'),
            ]);
            return redirect()->to(base_url().'admin/faqs');
        }
    
        // Delete an FAQ
        public function delete($id)
        {
            $this->faqModel->delete($id);
            return redirect()->to(base_url().'admin/faqs');
        }
    }
    