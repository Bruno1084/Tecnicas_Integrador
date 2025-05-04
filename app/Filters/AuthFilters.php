<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilters implements FilterInterface
{
    public function before(RequestInterface $request, $args = null)
    {
        $session = session();        
        $segments = explode('/', $request->getUri()->getPath());
        $lastSegment = end($segments);

        $publicRoutes = ['login', 'signUp', '/'];
        
        if (! $session->get('loggedIn') && !in_array($lastSegment, $publicRoutes)) {
            return redirect()->to('/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
