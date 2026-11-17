<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PendudukModel;

class Auth extends BaseController
{
    protected $userModel;
    protected $pendudukModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->pendudukModel = new PendudukModel();
    }

    public function login()
    {
        if (session()->get('is_logged_in')) {
            return redirect()->to(base_url('dashboard'));
        }

        return view('auth/login', [
            'title' => 'Login - SI Kependudukan Desa'
        ]);
    }

    public function attemptLogin()
    {
        $login = $this->request->getPost('login');
        $password = $this->request->getPost('password');

        if (empty($login) || empty($password)) {
            session()->setFlashdata('error', 'Username / Email dan Password wajib diisi.');
            return redirect()->back()->withInput();
        }

        $user = $this->userModel->findByLogin($login);

        if (!$user) {
            session()->setFlashdata('error', 'Akun tidak ditemukan. Silakan periksa kembali kredensial Anda.');
            return redirect()->back()->withInput();
        }

        if (!$user['is_active']) {
            session()->setFlashdata('error', 'Akun Anda dinonaktifkan. Silakan hubungi Administrator desa.');
            return redirect()->back()->withInput();
        }

        if (!password_verify($password, $user['password'])) {
            session()->setFlashdata('error', 'Password salah. Silakan coba lagi.');
            return redirect()->back()->withInput();
        }

        // Set session
        $sessionData = [
            'id_user'      => $user['id_user'],
            'username'     => $user['username'],
            'nama_lengkap' => $user['nama_lengkap'],
            'email'        => $user['email'],
            'role'         => $user['role'],
            'nik'          => $user['nik'],
            'is_logged_in' => true,
        ];
        session()->set($sessionData);

        session()->setFlashdata('success', 'Selamat datang kembali, ' . esc($user['nama_lengkap']) . '!');
        return redirect()->to(base_url('dashboard'));
    }

    public function register()
    {
        if (session()->get('is_logged_in')) {
            return redirect()->to(base_url('dashboard'));
        }

        return view('auth/register', [
            'title' => 'Registrasi Warga Mandiri'
        ]);
    }

    public function attemptRegister()
    {
        $nik = trim($this->request->getPost('nik'));
        $username = trim($this->request->getPost('username'));
        $email = trim($this->request->getPost('email'));
        $namaLengkap = trim($this->request->getPost('nama_lengkap'));
        $password = $this->request->getPost('password');
        $confirmPassword = $this->request->getPost('confirm_password');

        if (empty($nik) || empty($username) || empty($namaLengkap) || empty($password)) {
            session()->setFlashdata('error', 'Semua kolom bertanda bintang wajib diisi.');
            return redirect()->back()->withInput();
        }

        if (strlen($nik) !== 16 || !is_numeric($nik)) {
            session()->setFlashdata('error', 'NIK harus terdiri dari 16 digit angka.');
            return redirect()->back()->withInput();
        }

        if ($password !== $confirmPassword) {
            session()->setFlashdata('error', 'Konfirmasi password tidak cocok.');
            return redirect()->back()->withInput();
        }

        // Check if username already exists
        if ($this->userModel->where('username', $username)->first()) {
            session()->setFlashdata('error', 'Username sudah terdaftar. Silakan gunakan username lain.');
            return redirect()->back()->withInput();
        }

        // Check if NIK is already registered to another user
        if ($this->userModel->where('nik', $nik)->first()) {
            session()->setFlashdata('error', 'NIK ini sudah terdaftar sebagai akun pengguna.');
            return redirect()->back()->withInput();
        }

        // Check if NIK exists in resident table, if not, create initial resident data
        $existingPenduduk = $this->pendudukModel->where('nik', $nik)->first();
        if (!$existingPenduduk) {
            $this->pendudukModel->insert([
                'nik'                 => $nik,
                'no_kk'               => $this->request->getPost('no_kk') ?: $nik,
                'nama_lengkap'        => $namaLengkap,
                'jenis_kelamin'       => $this->request->getPost('jenis_kelamin') ?: 'L',
                'tempat_lahir'        => 'Bogor',
                'tanggal_lahir'       => '2000-01-01',
                'agama'               => 'Islam',
                'status_perkawinan'   => 'Belum Menikah',
                'shdk'                => 'Kepala Keluarga',
                'pekerjaan'           => 'Wiraswasta',
                'pendidikan_terakhir' => 'SLTA / SEDERAJAT',
                'alamat'              => 'Desa Jampang',
                'rt'                  => '001',
                'rw'                  => '001',
                'status_penduduk'     => 'Ada',
            ]);
        }

        $this->userModel->insert([
            'username'     => $username,
            'email'        => $email,
            'password'     => password_hash($password, PASSWORD_BCRYPT),
            'nama_lengkap' => $namaLengkap,
            'role'         => 'warga',
            'nik'          => $nik,
            'is_active'    => 1,
        ]);

        session()->setFlashdata('success', 'Pendaftaran akun berhasil! Silakan login dengan akun baru Anda.');
        return redirect()->to(base_url('login'));
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'))->with('info', 'Anda telah berhasil logout.');
    }
}
