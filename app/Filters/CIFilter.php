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
        $isLoggedIn = CIAuth::check();
        $userType = session()->get('is_admin') ? 'admin' : 'user';
    
        if ($arguments[0] === 'guest' && $isLoggedIn) {
            return redirect()->to(base_url('/'));
        }
    
        if ($arguments[0] === 'auth' && !$isLoggedIn) {
            return redirect()->to(base_url('admin/login'))->with('fail', 'You must be logged in first');
        }
    
        if ($arguments[0] === 'admin' && (!$isLoggedIn )) {

            return redirect()->to(base_url('admin/login'))->with('fail', 'You need to login to access');
        }
        if ($arguments[0] === 'admin' && ( $userType !== 'admin')) {

            return redirect()->to(base_url('login'))->with('fail', 'Unauthorized access');
        }

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
