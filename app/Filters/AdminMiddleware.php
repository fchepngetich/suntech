<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminMiddleware implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Check if the user is logged in
        if (!$session->has('logged_in')) {
            return redirect()->to(base_url('admin/login'))->with('fail', 'You must be logged in to access this section.');
        }

        // Check if the logged-in user is an admin
       // if (!$session->has('is_admin') || !$session->get('is_admin')) {
           // return redirect()->to(base_url('/'))->with('fail', 'Unauthorized access to admin area.');
        //}


  
    if (!$session->get('is_admin')) {
        return redirect()->to(base_url('admin/login'))->with('fail', 'You are not authorized to access this area');
    }


    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // You can add any additional processing needed after the request
    }
}
