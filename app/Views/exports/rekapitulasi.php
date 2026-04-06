<h1 style="text-align: center; font-family: Helvetica">Laporan Bulan <?= $bulan ?></h1>
<table style="font-family: Helvetica; width: 100%; border-collapse: collapse;">
    <tr style="background: #1e3a8a; color: white;">
        <th style="padding: 10px">Tanggal</th>
        <th style="padding: 10px">Total Transaksi</th>
        <th style="padding: 10px">Total Pendapatan</th>
    </tr>
    <?php foreach ($pertanggal as $key):?>
    <tr style="border-bottom: 2px solid black;">
        <td style="padding: 10px 0px; text-align: center"><?= $key['tanggal'] ?></td>
        <td style="padding: 10px 0px; text-align: center"><?= $key['transaksi'] ?></td>
        <td style="padding: 10px 15px; text-align: right">Rp<?= number_format($key['pendapatan'], 2, ',', '.') ?></td>
    </tr>
    <?php endforeach ?>
    <tr>
        <td style="padding: 10px 0px; text-align: center; font-weight: bold">TOTAL</td>
        <td style="padding: 10px 0px; text-align: center"><?= $transaksi ?></td>
        <td style="padding: 10px 15px; text-align: right">Rp<?= number_format($pendapatan, 2, ',', '.') ?></td>
    </tr>
</table>