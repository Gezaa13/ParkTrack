<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use PhpMqtt\Client\MqttClient;
use App\Models\Transaksi;
use App\Models\User;
use App\Models\Area;
use App\Models\Kendaraan;

class Subscribe extends BaseCommand
{
    protected $group       = 'MQTT';
    protected $name        = 'mqtt:subscribe';
    protected $description = 'Subscribe MQTT';

    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');

        $this->transaksi = new Transaksi();
        $this->user      = new User();
        $this->area      = new Area();
        $this->kendaraan = new Kendaraan();
    }

    public function run(array $params)
    {
        $server   = '127.0.0.1';
        $port     = 1883;
        $clientId = 'ci4-subscriber';

        $mqtt = new MqttClient($server, $port, $clientId);
        $mqtt->connect();

        $mqtt->subscribe('parking/hisan/entry/rfid', function ($topic, $message) use ($mqtt) {
            $cek = $this->area->first();
            if ($cek['terisi'] == $cek['kapasitas']) {
                $mqtt->publish('parking/hisan/lcd', 'Kapasitas Area Sudah Penuh', 1);
            } else {
                $cek = $this->kendaraan->find($message);
                if (!$cek || $cek['status_aktif'] == 0) {
                    $mqtt->publish('parking/hisan/lcd', 'Kendaraan Belum      Terdaftar Atau       Diaktivasi                                ID: ' . $message, 1);
                } else {
                    $cek = $this->transaksi->where('id_kartu', $message)->where('status', 'Masuk')->first();
                    if ($cek) {
                        $mqtt->publish('parking/hisan/lcd', 'Kendaraan Sudah      Terparkir                                 ID: ' . $message, 1);
                    } else {
                        $data = [
                            'id_kartu'    => $message,
                            'waktu_masuk' => date('Y-m-d H:i:s'),
                            'status'      => 'Masuk',
                        ];
                        $this->transaksi->insert($data);
                        $mqtt->publish('parking/hisan/lcd', 'Selamat Datang       Silahkan Masuk', 1);
                        $mqtt->publish('parking/hisan/entry/servo', 'TRUE', 1);
                    }
                }
            }
        }, 0);

        $mqtt->subscribe('parking/hisan/exit/rfid', function ($topic, $message) use ($mqtt) {
            $cek = $this->transaksi->where('id_kartu', $message)->where('status', 'Masuk')->first();
            if (!$cek) {
                $mqtt->publish('parking/hisan/lcd', 'Kendaraan Belum      Terparkir                                 ID: ' . $message, 1);
            } else {
                $waktuMasuk  = date('Y-m-d H:00:00', strtotime($cek['waktu_masuk']));
                $waktuKeluar = date('Y-m-d H:00:00');
                $mulai       = strtotime($waktuMasuk);
                $selesai     = strtotime($waktuKeluar);
                $selisih     = ($selesai - $mulai) / 3600;

                if ($selisih < 1) {
                    $selisih = 1;
                }

                $data = [
                    'waktu_keluar' => date('Y-m-d H:i:s'),
                    'durasi'       => $selisih,
                    'total'        => $selisih * 2000,
                    'status'       => 'keluar'
                ];
                $this->transaksi->update($cek['id_transaksi'], $data);

                $terisi = $this->area->find(1);
                $area = [
                    'terisi' => $terisi['terisi'] - 1
                ];
                $this->area->update(1, $area);
                $mqtt->publish('parking/hisan/lcd', 'Total Biaya:         Rp' . number_format($data['total'], 2, ',', '.'), 1);
            }
        }, 0);

        $mqtt->loop(true);
    }
}
