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
    log_message('info', "Update method called for blog ID: {id}", ['id' => $id]);

    $blogModel = new BlogModel();
    $data = [
        'title' => $this->request->getPost('title'),
        // 'description' => $this->request->getPost('description'),
    ];
    $data['description'] = htmlspecialchars($this->request->getPost('description'), ENT_QUOTES, 'UTF-8');


    log_message('info', "Form data received: {data}", ['data' => json_encode($data)]);

    $file = $this->request->getFile('image');
    if ($file && $file->isValid()) {
        log_message('info', "Image upload detected. Original name: {name}", ['name' => $file->getName()]);

        $imageName = $file->getName();
        if (!is_dir('images/blogs')) {
            mkdir('images/blogs', 0755, true); // Create folder if it doesn't exist
            log_message('info', "Image folder created: images/blogs");
        }

        try {
            $file->move('images/blogs', $imageName);
            $data['image'] = 'images/blogs/' . $imageName;
            log_message('info', "Image moved successfully: {path}", ['path' => $data['image']]);
        } catch (\Exception $e) {
            log_message('error', "Image upload error: {message}", ['message' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to upload image.');
        }
    } else {
        log_message('info', "No image uploaded or file is invalid.");
    }

    try {
        $blogModel->update($id, $data);
        log_message('info', "Blog updated successfully. Data: {data}", ['data' => json_encode($data)]);
        return redirect()->to(base_url('admin/blogs'))->with('success', 'Successfully updated');
    } catch (\Exception $e) {
        log_message('error', "Database update error: {message}", ['message' => $e->getMessage()]);
        return redirect()->back()->with('error', 'Failed to update blog.');
    }
}


    // public function update($id)
    // {
    //     $blogModel = new BlogModel();
    //     $data = [
    //         'title' => $this->request->getPost('title'),
    //         'description' => $this->request->getPost('description')
    //     ];

    //     // Check if a new image was uploaded
    //     $file = $this->request->getFile('image');
    //     if ($file && $file->isValid()) {
    //         $imageName = $file->getName(); // Use the original file name
    //         // Move the image to the specified folder
    //         $file->move('images/blogs', $imageName);
    //         $data['image'] = 'images/blogs/' . $imageName; // Update the image path
    //     }

    //     $blogModel->update($id, $data);
    //     return redirect()->to(base_url('admin/blogs'))->with('success', 'Successfully updated');
    // }

    public function delete($id)
    {
        $blogModel = new BlogModel();
        $blogModel->delete($id);
        return redirect()->to('/blogs');
    }

    public function show($id)
    {
        $blogModel = new BlogModel();
        $blog = $blogModel->find($id);
    
        $full_name = CIAuth::id(); 
    
        $data = [
            'blog' => $blog,
            'full_name' => $full_name
        ];
    
        if (!$blog) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Blog not found");
        }
    
        return view('admin/pages/blogs/show', $data);
    }
    

   
}

