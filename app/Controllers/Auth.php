<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\User;

class Auth extends BaseController
{
    public function __construct()
    {
        $this->user = new User();
    }

    public function index()
    {
        return view('auth/login');
    }

    public function login()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $this->user->where('username', $username)->first();

        if (!$user) {
            return redirect()->to('/')->with('errorUsername', "Username tidak ditemukan");
        } else {
            if ($user['status_aktif'] == 0) {
                return redirect()->to('/')->with('errorAktif', "User belum diaktivasi");
            } else {
                if (!password_verify($password, $user['password'])) {
                    return redirect()->to('/')->with('errorPassword', "Password tidak sesuai");
                } else {
                    session()->set([
                        'id'           => $user['id_user'],
                        'nama_lengkap' => $user['nama_lengkap'],
                        'role'         => $user['role']
                        ]);
                    switch (session('role')) {
                        case 'Admin':
                            return redirect()->to('/admin');
                            break;
                        case 'Owner':
                            return redirect()->to('/owner');
                            break;
                        case 'Petugas':
                            return redirect()->to('/petugas');
                            break;
                    }
                }
            }
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
