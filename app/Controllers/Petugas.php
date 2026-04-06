<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Transaksi;
use App\Models\User;
use App\Models\Area;
use App\Models\Kendaraan;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;

class Petugas extends BaseController
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');

        $this->transaksi = new Transaksi();
        $this->user      = new User();
        $this->area      = new Area();
        $this->kendaraan = new Kendaraan();
    }

    public function index()
    {
        $data['area'] = $this->area->first();
        $data['view'] = 'petugas/dashboard';
        return view('petugas/template', $data);
    }

    public function getMasuk()
    {
        $data = $this->transaksi->join('kendaraan', 'transaksi.id_kartu = kendaraan.id_kartu')->where('status', 'Masuk')->find();
        return $this->response->setJSON($data);
    }

    public function getKeluar()
    {
        $data = $this->transaksi->join('kendaraan', 'transaksi.id_kartu = kendaraan.id_kartu')->where('status', 'Keluar')->find();
        return $this->response->setJSON($data);
    }

    public function getLog()
    {
        $data = $this->transaksi->join('kendaraan', 'transaksi.id_kartu = kendaraan.id_kartu')->where('status', 'Selesai')->find();
        return $this->response->setJSON($data);
    }

    // public function masuk($idKartu)
    // {
    //     $cek = $this->area->first();
    //     if ($cek['terisi'] == $cek['kapasitas']) {
    //         return redirect()->to('/petugas');
    //     } else {
    //         $cek = $this->kendaraan->find($idKartu);
    //         if ($cek['status_aktif'] == 0) {
    //             return redirect()->to('/petugas')->with('errorStatus', 'Kendaraan sudah dinonaktifkan');
    //         } else {
    //             $cek = $this->transaksi->where('id_kartu', $idKartu)->where('status', 'Masuk')->first();
    //             if ($cek) {
    //                 return redirect()->to('/petugas')->with('errorMasuk', 'Kendaraan sudah parkir');
    //             } else {
    //                 $data = [
    //                     'id_kartu'    => $idKartu,
    //                     'id_user'     => session('id'),
    //                     'waktu_masuk' => date('Y-m-d H:i:s'),
    //                     'status'      => 'Masuk',
    //                     ];
    //                 $this->transaksi->insert($data);
    //                 return redirect()->to('/petugas');
    //             }
    //         }
    //     }

    // }

    // public function keluar($idKartu)
    // {
    //     $cek = $this->transaksi->where('id_kartu', $idKartu)->where('status', 'Masuk')->first();
    //     if (!$cek) {
    //         return redirect()->to('/petugas')->with('errorKeluar', 'Kendaraan belum parkir');
    //     } else {
    //         $waktuMasuk  = date('Y-m-d H:00:00', strtotime($cek['waktu_masuk']));
    //         $waktuKeluar = date('Y-m-d H:00:00');
    //         $mulai       = strtotime($waktuMasuk);
    //         $selesai     = strtotime($waktuKeluar);
    //         $selisih     = ($selesai - $mulai) / 3600;

    //         if ($selisih < 1) {
    //             $selisih = 1;
    //         }

    //         $data = [
    //             'waktu_keluar' => date('Y-m-d H:i:s'),
    //             'durasi'       => $selisih,
    //             'total'        => $selisih * 2000,
    //             'status'       => 'keluar'
    //         ];
    //         $this->transaksi->update($cek['id_transaksi'], $data);

    //         $terisi = $this->area->find(1);
    //         $data = [
    //             'terisi' => $terisi['terisi'] - 1
    //         ];
    //         $this->area->update(1, $data);
    //         return redirect()->to('/petugas');
    //     }
    // }

    public function selesai($idTransaksi)
    {
        $data = [
            'status'  => 'Selesai'
        ];
        $this->transaksi->update($idTransaksi, $data);
        $server   = '127.0.0.1';
        $port     = 1883;
        $clientId = 'ci4-publisher';

        $mqtt = new MqttClient($server, $port, $clientId);
        $connectionSettings = (new ConnectionSettings())->setKeepAliveInterval(60);

        $mqtt->connect($connectionSettings, true);
        $mqtt->publish('parking/hisan/lcd', 'Terima Kasih Selamat Jalan', 0);
        $mqtt->publish('parking/hisan/exit/servo', 'TRUE', 0);
        $mqtt->disconnect();
        return redirect()->to('/petugas');
    }

    public function cetakStruk($idTransaksi)
    {
        $data = $this->transaksi->find($idTransaksi);
        $html = view('exports/transaksi', $data);
        $txt = strip_tags($html);

        return $this->response->download('struk.txt', $txt);
    }
}
