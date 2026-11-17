<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PendudukModel;

class User extends BaseController
{
    protected $userModel;
    protected $pendudukModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->pendudukModel = new PendudukModel();
    }

    public function index()
    {
        $users = $this->userModel->orderBy('role', 'ASC')->findAll();

        return view('user/index', [
            'title' => 'Manajemen Pengguna Sistem',
            'users' => $users
        ]);
    }

    public function create()
    {
        return view('user/create', [
            'title' => 'Tambah Pengguna Baru'
        ]);
    }

    public function store()
    {
        $username = trim($this->request->getPost('username'));
        $nama     = trim($this->request->getPost('nama_lengkap'));
        $email    = trim($this->request->getPost('email'));
        $password = $this->request->getPost('password');
        $role     = $this->request->getPost('role');
        $nik      = trim($this->request->getPost('nik'));

        if (empty($username) || empty($nama) || empty($password) || empty($role)) {
            return redirect()->back()->withInput()->with('error', 'Semua kolom bertanda bintang wajib diisi.');
        }

        if ($this->userModel->where('username', $username)->first()) {
            return redirect()->back()->withInput()->with('error', 'Username ' . $username . ' sudah digunakan.');
        }

        $this->userModel->insert([
            'username'     => $username,
            'nama_lengkap' => $nama,
            'email'        => $email ?: null,
            'password'     => password_hash($password, PASSWORD_BCRYPT),
            'role'         => $role,
            'nik'          => $nik ?: null,
            'is_active'    => 1
        ]);

        return redirect()->to(base_url('user'))->with('success', 'Pengguna ' . $nama . ' (' . $role . ') berhasil ditambahkan.');
    }

    public function toggleActive(int $id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to(base_url('user'))->with('error', 'Pengguna tidak ditemukan.');
        }

        if ($user['id_user'] == session()->get('id_user')) {
            return redirect()->to(base_url('user'))->with('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri.');
        }

        $newStatus = $user['is_active'] ? 0 : 1;
        $this->userModel->update($id, ['is_active' => $newStatus]);

        $statusStr = $newStatus ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->to(base_url('user'))->with('success', 'Akun ' . $user['username'] . ' berhasil ' . $statusStr . '.');
    }

    public function profil()
    {
        $id = session()->get('id_user');
        $user = $this->userModel->find($id);

        return view('user/profil', [
            'title' => 'Profil Saya',
            'user'  => $user
        ]);
    }

    public function updateProfil()
    {
        $id = session()->get('id_user');
        $user = $this->userModel->find($id);

        $nama  = trim($this->request->getPost('nama_lengkap'));
        $email = trim($this->request->getPost('email'));
        $pass  = $this->request->getPost('password');

        $updateData = [
            'nama_lengkap' => $nama,
            'email'        => $email
        ];

        if (!empty($pass)) {
            if (strlen($pass) < 6) {
                return redirect()->back()->with('error', 'Password minimal 6 karakter.');
            }
            $updateData['password'] = password_hash($pass, PASSWORD_BCRYPT);
        }

        $this->userModel->update($id, $updateData);
        session()->set('nama_lengkap', $nama);
        session()->set('email', $email);

        return redirect()->to(base_url('profil'))->with('success', 'Profil dan informasi akun berhasil diperbarui.');
    }
}
