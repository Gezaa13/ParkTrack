<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Transaksi;
use DateTime;
use Dompdf\Dompdf;
use Dompdf\Options;

class Owner extends BaseController
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');

        $this->transaksi = new Transaksi();
    }

    public function index()
    {
        $data['view'] = 'owner/dashboard';
        return view('owner/template', $data);
    }

    public function getTransaksiCard($bulan)
    {
        $awal  = date('Y-m-d 00:00:00', strtotime("$bulan-01"));
        $akhir = date('Y-m-t 23:59:59', strtotime("$bulan-01"));
        $data  = $this->transaksi->where('waktu_keluar >=', $awal)->where('waktu_keluar <=', $akhir)->countAllResults();
        return $this->response->setJSON($data);
    }

    public function getPendapatanCard($bulan)
    {
        $awal   = date('Y-m-d 00:00:00', strtotime("$bulan-01"));
        $akhir  = date('Y-m-t 23:59:59', strtotime("$bulan-01"));
        $data   = $this->transaksi->where('waktu_keluar >=', $awal)->where('waktu_keluar <=', $akhir)->findAll();
        $jumlah = 0;
        foreach ($data as $key) {
            $jumlah += $key['total'];
        }
        return $this->response->setJSON($jumlah);
    }

    public function getTransaksiChart($bulan)
    {
        $awal  = date('Y-m-d', strtotime("$bulan-01"));
        $akhir = date('Y-m-t', strtotime("$bulan-01"));

        for ($awal; $awal <= $akhir; $awal++) {
            $transaksi[$awal] = 0;
        }

        $awal  = date('Y-m-d 00:00:00', strtotime("$bulan-01"));
        $akhir = date('Y-m-t 23:59:59', strtotime("$bulan-01"));
        $data  = $this->transaksi->where('waktu_keluar >=', $awal)->where('waktu_keluar <=', $akhir)->findAll();

        foreach ($data as $key) {
            $tanggal = date('Y-m-d', strtotime($key['waktu_keluar']));
            $transaksi[$tanggal] += 1;
        }

        return $this->response->setJSON($transaksi);
    }

    public function getPendapatanChart($bulan)
    {
        $awal = date('Y-m-d', strtotime("$bulan-01"));
        $akhir = date('Y-m-t', strtotime("$bulan-01"));

        for ($awal; $awal <= $akhir; $awal++) {
            $transaksi[$awal] = 0;
        }

        $awal  = date('Y-m-d 00:00:00', strtotime("$bulan-01"));
        $akhir = date('Y-m-t 23:59:59', strtotime("$bulan-01"));
        $data  = $this->transaksi->where('waktu_keluar >=', $awal)->where('waktu_keluar <=', $akhir)->findAll();

        foreach ($data as $key) {
            $tanggal = date('Y-m-d', strtotime($key['waktu_keluar']));
            $transaksi[$tanggal] += $key['total'];
        }

        return $this->response->setJSON($transaksi);
    }

    public function getTable($bulan)
    {
        $awal  = date('Y-m-d', strtotime("$bulan-01"));
        $akhir = date('Y-m-t 23:59:59', strtotime("$bulan-01"));
        $data  = $this->transaksi->select('DATE(waktu_keluar) as tanggal, COUNT(*) as transaksi, SUM(total) as pendapatan')->where('waktu_keluar >=', $awal)->where('waktu_keluar <=', $akhir)->groupBy('DATE(waktu_keluar)')->findAll();

        return $this->response->setJSON($data);
    }

    public function export($bulan)
    {
        $awal  = date('Y-m-d', strtotime("$bulan-01"));
        $akhir = date('Y-m-t', strtotime("$bulan-01"));
        $query = $this->transaksi->where('waktu_keluar >=', $awal)->where('waktu_keluar <=', $akhir)->findAll();
        $data['pendapatan'] = 0;
        foreach ($query as $key) {
            $data['pendapatan'] += $key['total'];
        }

        $data['pertanggal'] = $this->transaksi->select('DAY(waktu_keluar) as tanggal, COUNT(*) as transaksi, SUM(total) as pendapatan')->where('waktu_keluar >=', $awal)->where('waktu_keluar <=', $akhir)->groupBy('DATE(waktu_keluar)')->findAll();
        $data['bulan'] = date('F Y', strtotime("$bulan"));
        $data['transaksi'] = $this->transaksi->where('waktu_keluar >=', $awal)->where('waktu_keluar <=', $akhir)->countAllResults();

        $html = view('exports/rekapitulasi', $data);
        $options = new Options();
        $options->set('isRemoteEnavled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'potrait');
        $dompdf->render();
        $dompdf->stream("Laporan {$data['bulan']}.pdf", ['Attachment' => true]);
    }
}
