<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\BlogModel;
use App\Models\AboutModel;
use App\Models\FaqModel;



class PagesController extends BaseController
{
//     public function ourImpact()
// {
//     $blogModel = new BlogModel();
//     $blogs = $blogModel->orderBy('created_at', 'DESC')->findAll(); // Use findAll() for multiple results

//     $data = [
//         'blogs' => $blogs, // Pass the blogs data to the view
//     ];

//     return view('backend/pages/inner-pages/our-impact', $data); // Ensure the view path is correct
// }

public function ourImpact() {
    $db = \Config\Database::connect();
    $builder = $db->table('blogs');

    $perPage = 3;

    $totalBlogs = $builder->countAllResults(false); 

    $currentPage = $this->request->getVar('page') ?? 1;

    $blogs = $builder->limit($perPage, ($currentPage - 1) * $perPage)->get()->getResultArray();

    return view('backend/pages/inner-pages/our-impact', [
        'blogs' => $blogs,
        'pager' => \Config\Services::pager(),
        'totalBlogs' => $totalBlogs,
        'perPage' => $perPage,
        'currentPage'=>$currentPage
        
    ]);
}

public function aboutUs()
{
    $model = new AboutModel();
    
    // Fetch all About Us entries
    // $data['about_us'] = $model->findAll();
    $data['about_us'] = $model->orderBy('created_at', 'ASC')->limit(1)->findAll();
    $data['about_us_second'] = $model->orderBy('created_at', 'ASC')->limit(1, 1)->findAll();
    $data['about_us_third'] = $model->orderBy('created_at', 'ASC')->limit(1, 2)->findAll();
    $data['about_us_choose_us'] = $model->orderBy('created_at', 'ASC')->limit(1, 3)->findAll();
    $data['about_us_what_we_do'] = $model->orderBy('created_at', 'ASC')->limit(4, 4)->findAll();
    $data['about_us_market'] = $model->orderBy('created_at', 'ASC')->limit(1, 8)->findAll();

    
    return view('backend/pages/inner-pages/about-us', $data); 
}

public function contact()
{
    return view('backend/pages/inner-pages/contact-us'); // Render the contact view
}
// public function faqs()
//     {
//         $faqModel = new FaqModel();
//         $data['faqs'] = $faqModel->findAll(); 

//         return view('backend/pages/inner-pages/faqs', $data); 
//     }

    public function faqs()
{
    $db = \Config\Database::connect();
    $builder = $db->table('faqs');

    $perPage = 10;  // Set the number of FAQs per page

    // Get the current page from the query string, default to 1
    $currentPage = $this->request->getVar('page') ?? 1;

    // Retrieve FAQs with pagination
    $faqs = $builder->limit($perPage, ($currentPage - 1) * $perPage)->get()->getResultArray();

    return view('backend/pages/inner-pages/faqs', [
        'faqs' => $faqs,
        'pager' => \Config\Services::pager(),
        'totalFaqs' => $builder->countAll(),
        'perPage' => $perPage,
        'currentPage' => $currentPage,
    ]);
}


}
