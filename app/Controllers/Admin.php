<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\User;
use App\Models\Area;
use App\Models\Kendaraan;

class Admin extends BaseController
{
    public function __construct()
    {
        $this->user = new User();
        $this->area = new Area();
        $this->kendaraan = new Kendaraan();
    }

    public function index()
    {
        $data['totalUser']      = $this->user->countAll();
        $data['userAktif']      = $this->user->where('status_aktif', 1)->countAllResults();
        $data['area']           = $this->area->first();
        $data['kendaraanAktif'] = $this->kendaraan->where('status_aktif', 1)->countAllResults();
        $data['rasioUser']      = $this->user->select('role, COUNT(*) as total')->groupBy('role')->where('status_aktif', 1)->findAll();
        $data['view']           = 'admin/dashboard';
        return view('admin/template', $data);
    }

    public function ubahKapasitas()
    {
        $data = [
            'kapasitas' => $this->request->getPost('kapasitas')
        ];
        if ($data['kapasitas'] <= 0) {
            return redirect()->to('/admin')->with('errorKapasitas', 'Kapasitas tidak valid');
        } else {
            $this->area->update(1, $data);
            return redirect()->to('/admin');
        }
    }

    public function user()
    {
        $data['view'] = 'admin/user';
        return view('admin/template', $data);
    }

    public function getUser()
    {
        $data = $this->user->orderBy('status_aktif', 'DESC')->findAll();
        return  $this->response->setJSON($data);
    }

    public function formTambahUser()
    {
        $data['view'] = 'admin/tambahUserForm';
        return view('admin/template', $data);
    }

    public function tambahUser()
    {
        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'username'     => $this->request->getPost('username'),
            'password'     => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'         => $this->request->getPost('role'),
        ];
        $cek = $this->user->where('username', $data['username'])->first();
        if ($cek) {
            return redirect()->to('/admin/user/tambah')->with('errorUsername', 'Username sudah digunakan');
        } else {
            $this->user->insert($data);
            return redirect()->to('/admin/user');
        }
    }

    public function formUbahUser($idUser)
    {
        $data['user'] = $this->user->find($idUser);
        $data['view'] = 'admin/ubahUserForm';
        return view('admin/template', $data);
    }

    public function ubahUser($idUser)
    {
        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'username'     => $this->request->getPost('username'),
        ];
        $cek = $this->user->find($idUser);
        if ($cek['username'] == $data['username']) {
            $this->user->update($idUser, $data);
            return redirect()->to('/admin/user');
        } else {
            $cek = $this->user->where('username', $data['username'])->first();
            if ($cek) {
                return redirect()->to('/admin/user/ubah/' . $idUser)->with('errorUsername', 'Username sudah digunakan');
            } else {
                $this->user->update($idUser, $data);
                return redirect()->to('/admin/user');
            }
        }
    }

    public function aktivasiUser($idUser)
    {
        $cek = $this->user->find($idUser);
        if ($cek['status_aktif'] == 1) {
            $this->user->update($idUser, ['status_aktif' => 0]);
        } else {
            $this->user->update($idUser, ['status_aktif' => 1]);
        }
        return redirect()->to('/admin/user');
    }

    public function kendaraan()
    {
        $data['view'] = 'admin/kendaraan';
        return view('admin/template', $data);
    }

    public function getKendaraan()
    {
        $data = $this->kendaraan->orderBy('status_aktif', 'DESC')->findAll();
        return  $this->response->setJSON($data);
    }

    public function formTambahKendaraan()
    {
        $data['view'] = 'admin/tambahKendaraanForm';
        return view('admin/template', $data);
    }

    public function tambahKendaraan()
    {
        $data = [
            'id_kartu'   => $this->request->getPost('id_kartu'),
            'plat_nomor' => $this->request->getPost('plat_nomor'),
            'pemilik'    => $this->request->getPost('pemilik'),
        ];
        $cek = $this->kendaraan->where('plat_nomor', $data['plat_nomor'])->orWhere('id_kartu', $data['id_kartu'])->first();
        if ($cek) {
            return redirect()->to('/admin/kendaraan/tambah')->with('error', 'Kendaraan sudah terdaftar');
        } else {
            $this->kendaraan->insert($data);
            return redirect()->to('/admin/kendaraan');
        }
    }

    public function formUbahKendaraan($idKartu)
    {
        $data['kendaraan'] = $this->kendaraan->find($idKartu);
        $data['view']      = 'admin/ubahKendaraanForm';
        return view('admin/template', $data);
    }

    public function ubahKendaraan($idKartu)
    {
        $data = [
            'id_kartu'   => $this->request->getPost('id_kartu'),
            'plat_nomor' => $this->request->getPost('plat_nomor'),
            'pemilik'    => $this->request->getPost('pemilik'),
        ];
        $cek = $this->kendaraan->find($idKartu);
        if ($cek['plat_nomor'] == $data['plat_nomor'] || $cek['id_kartu'] == $data['id_kartu']) {
            $this->kendaraan->update($idKartu, $data);
            return redirect()->to('/admin/kendaraan');
        } else {
            $cek = $this->kendaraan->where('plat_nomor', $data['plat_nomor'])->orWhere('id_kartu', $data['id_kartu'])->first();
            if ($cek) {
                return redirect()->to('/admin/kendaraan/ubah/' . $idKartu)->with('error', 'Kendaraan sudah terdaftar');
            } else {
                $this->kendaraan->update($idKartu, $data);
                return redirect()->to('/admin/kendaraan');
            }
        }
    }

    public function aktivasiKendaraan($idKartu)
    {
        $cek = $this->kendaraan->find($idKartu);
        if ($cek['status_aktif'] == 1) {
            $this->kendaraan->update($idKartu, ['status_aktif' => 0]);
        } else {
            $this->kendaraan->update($idKartu, ['status_aktif' => 1]);
        }
        return redirect()->to('/admin/kendaraan');
    }
}
