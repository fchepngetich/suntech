<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\MenuModel;
use App\Libraries\CIAuth;

class MenuController extends BaseController
{
   
        protected $menuModel;
    
        public function __construct()
        {
            $this->menuModel = new MenuModel();
        }
    
        // Display all menus
        public function index()
{
    $full_name = CIAuth::id();  

    $data = [
        'full_name' => $full_name,
        'menus' => $this->menuModel->findAll()
    ];

    return view('admin/pages/menus/index', $data);
}

    
        // Show form to create a new menu
        public function create()
        {
            $full_name = CIAuth::id();  

    $data = [
        'full_name' => $full_name,
    ];
            return view('admin/pages/menus/create',$data);
        }
    
        // Store the new menu in the database
        public function store()
        {
            $this->menuModel->save([
                'name' => $this->request->getPost('name')
            ]);
    
            return redirect()->to(base_url().'admin/menus')->with('message', 'Menu created successfully!');
        }
    
        // Show form to edit a menu
        public function edit($id)
{
    $full_name = CIAuth::id();  

    // Find the menu by ID
    $menu = $this->menuModel->find($id);

    // Prepare the data array
    $data = [
        'full_name' => $full_name,
        'menu' => $menu
    ];

    // Pass the data to the view
    return view('admin/pages/menus/edit', $data);
}

    
        // Update the menu in the database
        public function update($id)
        {
            $this->menuModel->update($id, [
                'name' => $this->request->getPost('name')
            ]);
    
            return redirect()->to('admin/menus')->with('message', 'Menu updated successfully!');
        }
    
        // Delete a menu
        public function delete($id)
        {
            $this->menuModel->delete($id);
            return redirect()->to('admin/menus')->with('message', 'Menu deleted successfully!');
        }


        public function indexs()
        {
            $menuModel = new MenuModel();
            $menus = $menuModel->getMenus(); // Get all menus
            
            return view('menu/index', ['menus' => $menus]);
        }
        
        public function viewArticle($slug)
        {
            $articleModel = new ArticleModel();
            $article = $articleModel->getArticleBySlug($slug); // Get article by menu slug
            
            if (!$article) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }
            
            return view('menu/article', ['article' => $article]);
        }


    }
    