<?php

namespace App\Http\Controllers;

use App\Models\AccPenjualan;
use App\Models\Pembelian;
use App\Models\Pengeluaran;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tanggalAwal = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
        $tanggalAkhir = date('Y-m-d');

        if ($request->has('tanggal_awal') && $request->tanggal_awal != "" && $request->has('tanggal_akhir') && $request->tanggal_akhir) {
            $tanggalAwal = $request->tanggal_awal;
            $tanggalAkhir = $request->tanggal_akhir;
        }

        return view('laporan.index', compact('tanggalAwal', 'tanggalAkhir'));
    }

    public function data($awal, $akhir)
    {
        $data = $this->getData($awal, $akhir);

        return datatables()
            ->of($data)
            ->make(true);
    }

    // Bagian getData
    public function getData($awal, $akhir)
    {
        $no = 1;
        $data = array();
        $pendapatan = 0;
        $total_pendapatan = 0;

        while (strtotime($awal) <= strtotime($akhir)) {
            $tanggal = $awal;
            $awal = date('Y-m-d', strtotime("+1 day", strtotime($awal)));

            $penjualan = AccPenjualan::where('created_at', 'LIKE', "%$tanggal%")
                ->where('status', 'Terkirim')
                ->get();

            foreach ($penjualan as $item) {
                $total_penjualan = $item->total_bayar;

                $pendapatan = $total_penjualan;
                $total_pendapatan += $pendapatan;

                $row = array();
                $row['DT_RowIndex'] = $no++;
                $row['tanggal'] = tanggal_indonesia($tanggal, false);
                $row['penjualan'] = format_uang($total_penjualan);
                $row['pendapatan'] = format_uang($pendapatan);

                $data[] = $row;
            }
        }

        $data[] = [
            'DT_RowIndex' => '',
            'tanggal' => '',
            'penjualan' => '',
            'pendapatan' => format_uang($total_pendapatan),
        ];

        return $data;
    }

    public function exportPDF($awal, $akhir)
    {
        $data = $this->getData($awal, $akhir);

        if (empty($data)) {
            return response()->json(['message' => 'Tidak ada data untuk diekspor.']);
        }

        // Header untuk membuat file PDF
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="Laporan-pendapatan-' . date('Y-m-d-his') . '.pdf"');

        // Membuka file PDF
        $pdf = fopen('php://output', 'w');

        // Isi PDF
        $html = '<h1>Laporan Pendapatan</h1>';
        $html .= '<p>Periode: ' . $awal . ' sampai ' . $akhir . '</p>';

        $html .= '<table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Penjualan</th>
                <th>Pendapatan</th>
            </tr>
        </thead>
        <tbody>';

        foreach ($data as $key => $item) {
            $html .= '<tr>
            <td>' . $item['DT_RowIndex'] . '</td>
            <td>' . $item['tanggal'] . '</td>
            <td>' . $item['penjualan'] . '</td>
            <td>' . $item['pendapatan'] . '</td>
        </tr>';
        }

        $html .= '</tbody></table>';

        fwrite($pdf, $html);

        // Menutup file PDF
        fclose($pdf);
    }

}
