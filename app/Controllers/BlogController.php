<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\CIAuth;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\BlogModel;

class BlogController extends BaseController
{
    // File: app/Controllers/BlogController.php

    public function index()
    {
        $full_name =CIAuth::id();
        $blogModel = new BlogModel();
        $data['blogs'] = $blogModel->findAll();
        $data['full_name'] = $full_name;
        return view('admin/pages/blogs/blogs', $data);
    }

    public function blogDetails($id)
    {
        $blogModel = new BlogModel();
        
        $data['blog'] = $blogModel->where('id', $id)->first();
        return view('backend/pages/blogs/blog-details', $data);
    
    
    }

    public function blogs() {
        $full_name =CIAuth::id();
        $blogModel = new BlogModel();
        $data['blogs'] = $blogModel->findAll();
        $data['full_name'] = $full_name;

        return view('backend/pages/blogs/blogs', $data);
    }

    public function create()
    {
        $full_name =CIAuth::id();
        $data['full_name'] = $full_name;

        return view('admin/pages/blogs/create',$data);
    }

    public function store()
    {
        $blogModel = new BlogModel();

        // Upload image if available
        $file = $this->request->getFile('image');
        if ($file && $file->isValid()) {
            $imageName = $file->getName(); // Use the original file name

            // Move the image to the specified folder
            $file->move('images/blogs', $imageName);

            // Store blog details
            $data = [
                'title' => $this->request->getPost('title'),
                'image' => 'images/blogs/' . $imageName, // Save the relative path
                'description' => $this->request->getPost('description')
            ];

            $blogModel->save($data);
        }

        return redirect()->to(base_url('admin/blogs'))->with('success', 'Blog added successfully');
    }

    public function edit($id)
    {
        $full_name =CIAuth::id();
        $data['full_name'] = $full_name;

        $blogModel = new BlogModel();
        $data['blog'] = $blogModel->find($id);
        return view('admin/pages/blogs/edit', $data);
    }

    public function update($id)
    {
        $blogModel = new BlogModel();
        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description')
        ];

        // Check if a new image was uploaded
        $file = $this->request->getFile('image');
        if ($file && $file->isValid()) {
            $imageName = $file->getName(); // Use the original file name
            // Move the image to the specified folder
            $file->move('images/blogs', $imageName);
            $data['image'] = 'images/blogs/' . $imageName; // Update the image path
        }

        $blogModel->update($id, $data);
        return redirect()->to(base_url('admin/blogs'))->with('success', 'Successfully updated');
    }

    public function delete($id)
    {
        $blogModel = new BlogModel();
        $blogModel->delete($id);
        return redirect()->to('/blogs');
    }

   
}

