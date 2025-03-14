<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;

use CodeIgniter\HTTP\RequestInterface;

use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface

{

    public function before(RequestInterface $request, $arguments = null)
    {

        // Pastikan user sudah login

        if (!logged_in()) {

            return redirect()->to(site_url('login'));
        }

        // Periksa jika user memiliki role yang sesuai

        foreach ($arguments as $group) {
            if (in_groups($group)) {
                return;
            }
        }

        // Jika tidak memiliki role yang sesuai

        return redirect()->to(site_url('unauthorized'));
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
