<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AboutModel;
use App\Libraries\CIAuth;

class AboutController extends BaseController
{


    public function details($id)
    {
        $model = new AboutModel();
        $item = $model->find($id); // Fetch the item from the database

        if (!$item) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Item not found');
        }

        return view('backend/pages/inner-pages/about_us_details', ['item' => $item]);
    }
        public function index()
        {
            $full_name =CIAuth::id();
        $data['full_name'] = $full_name;
            $model = new AboutModel();
            $data['about_us'] = $model->findAll();
            return view('admin/pages/about_us/index', $data);
        }
    
        public function create()
        {
            $full_name =CIAuth::id();
            $data['full_name'] = $full_name;
            return view('admin/pages/about_us/create',$data);
        }
    
        public function store()
        {
            $model = new AboutModel();
        
            $data = [
                'name' => $this->request->getPost('name'),
                'description' => $this->request->getPost('description'),
            ];
        
            // Image upload
            if ($img = $this->request->getFile('image')) {
                if ($img->isValid() && !$img->hasMoved()) {
                    $imageName = $img->getRandomName();
                    // Move the file to images/aboutus directory
                    $img->move('images/aboutus', $imageName);
                    $data['image'] = $imageName;
                }
            }
        
            $model->insert($data);
            return redirect()->to('admin/about-us')->with('success', 'About Us entry created successfully.');
        }
        
        public function edit($id)
        {
            $full_name =CIAuth::id();
            $data['full_name'] = $full_name;
            $model = new AboutModel();
            $data['about_us'] = $model->find($id);
            return view('admin/pages/about_us/edit', $data);
        }
    
        public function update($id)
        {
            $model = new AboutModel();
    
            $data = [
                'name' => $this->request->getPost('name'),
                'description' => $this->request->getPost('description'),
            ];
    
            // Image upload
            if ($img = $this->request->getFile('image')) {
                if ($img->isValid() && !$img->hasMoved()) {
                    $imageName = $img->getRandomName();
                    $img->move('uploads/', $imageName);
                    $data['image'] = $imageName;
                }
            }
    
            $model->update($id, $data);
            return redirect()->to('admin/about-us')->with('success', 'About Us entry updated successfully.');
        }
    
        public function delete($id)
        {
            $model = new AboutModel();
            $model->delete($id);
            return redirect()->to('admin/about-us')->with('success', 'About Us entry deleted successfully.');
        }
    }
    