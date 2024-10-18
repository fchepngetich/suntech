<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\CIAuth;


class CIFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return RequestInterface|ResponseInterface|string|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Check if the user is logged in
        $isLoggedIn = CIAuth::check();
        $userType = session()->get('is_admin') ? 'admin' : 'user';
    
        if ($arguments[0] === 'guest' && $isLoggedIn) {
            // Redirect logged-in users to home if accessing a guest-only page
            return redirect()->to(base_url('/'));
        }
    
        if ($arguments[0] === 'auth' && !$isLoggedIn) {
            // Redirect guests to login if accessing a protected page
            return redirect()->to(base_url('admin/login'))->with('fail', 'You must be logged in first');
        }
    
        if ($arguments[0] === 'admin' && (!$isLoggedIn || $userType !== 'admin')) {
            // Restrict access to admin routes for non-admin users or guests
            return redirect()->to(base_url('login'))->with('fail', 'Unauthorized access');
        }
    
        // No redirection needed; continue with the request
        return;
    }
    

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return ResponseInterface|void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
