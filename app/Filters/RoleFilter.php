<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('is_logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $userRole = session()->get('role');
        if (!empty($arguments)) {
            if (!in_array($userRole, $arguments)) {
                session()->setFlashdata('error', 'Akses ditolak: Anda tidak memiliki izin untuk modul ini.');
                return redirect()->to(base_url('dashboard'));
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
