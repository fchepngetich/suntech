<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\ArticleModel;
use App\Libraries\CIAuth;

class ArticleController extends BaseController
{
    public function index()
    {
        $full_name = CIAuth::id();  

    $data = [
        'full_name' => $full_name,
    ];
        $articleModel = new ArticleModel();
        $data['articles'] = $articleModel->getAllArticles(); // Get all articles

        return view('admin/pages/articles/index', $data);
    }

    // Show the form to create a new article
    public function create()
    {
        $full_name = CIAuth::id();  

        $data = [
            'full_name' => $full_name,
        ];
        return view('admin/pages/articles/create',$data);
    }

    // Store the new article in the database
    public function store()
    {
        $articleModel = new ArticleModel();

        // Validate input data
        if ($this->request->getMethod() === 'post' && $this->validate([
            'title' => 'required|min_length[3]',
            'content' => 'required',
        ])) {
            $articleModel->save([
                'title' => $this->request->getPost('title'),
                'slug' => url_title($this->request->getPost('title'), '-', TRUE), // Generate slug
                'content' => $this->request->getPost('content'),
                'menu_id' => $this->request->getPost('menu_id'),
            ]);

            return redirect()->to('/articles')->with('message', 'Article created successfully');
        }

        return view('admin/pages/articles/create');
    }

    // Show a single article
    public function show($id)
    {
        $articleModel = new ArticleModel();
        $data['article'] = $articleModel->find($id); // Find article by ID

        if (!$data['article']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Article not found');
        }

        return view('articles/show', $data);
    }

    // Edit an article
    public function edit($id)
    {
        $articleModel = new ArticleModel();
        $data['article'] = $articleModel->find($id);

        if (!$data['article']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Article not found');
        }

        return view('articles/edit', $data);
    }

    // Update the article in the database
    public function update($id)
    {
        $articleModel = new ArticleModel();

        // Validate the updated data
        if ($this->request->getMethod() === 'post' && $this->validate([
            'title' => 'required|min_length[3]',
            'content' => 'required',
        ])) {
            $articleModel->update($id, [
                'title' => $this->request->getPost('title'),
                'slug' => url_title($this->request->getPost('title'), '-', TRUE), // Generate slug
                'content' => $this->request->getPost('content'),
                'menu_id' => $this->request->getPost('menu_id'),
            ]);

            return redirect()->to('/articles')->with('message', 'Article updated successfully');
        }

        return view('articles/edit', ['article' => $articleModel->find($id)]);
    }

    // Delete an article
    public function delete($id)
    {
        $articleModel = new ArticleModel();
        $articleModel->delete($id); // Delete article by ID

        return redirect()->to('/articles')->with('message', 'Article deleted successfully');
    }
}

