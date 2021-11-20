<?php

namespace App\Modules\Admin\Controllers;

use App\Modules\Admin\Models\floristModel;
use FPDF;



class CetakPDF extends BaseController
{
    protected $floristModel;

    public function __construct()
    {
        $this->floristModel = new floristModel();
    }

    function index()
    {
        error_reporting(0);
        $pdf = new FPDF('L', 'mm', 'Letter');
        $pdf->AddPage('l', 'legal');
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(100, 7, 'LAPORAN DATA PENJUALAN ', 0, 1, 'C');
        $pdf->Cell(10, 7, '', 0, 1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 6, 'NO ', 1, 0);
        $pdf->Cell(25, 6, 'GAMBAR ', 1, 0);
        $pdf->Cell(50, 6, 'NAMA PRODUK ', 1, 0);
        $pdf->Cell(30, 6, 'JENIS BUNGA ', 1, 0);
        $pdf->Cell(45, 6, 'TIPE BUKET ', 1, 0);
        $pdf->Cell(35, 6, 'Harga', 1, 1);

        $pdf->SetFont('Arial', '', 10);

        $i = 1;
        $florist = $this->floristModel->getBunga();
        foreach ($florist as $item) {
            $pdf->Cell(10, 20, $i++, 1, 0);
            $img = base_url('img/upload/' . $item['gambar']);
            $pdf->Cell(25, 20, $pdf->Image($img, $pdf->GetX(), $pdf->GetY(), 15), 1, 0);
            $pdf->Cell(50, 20, $item['nama_produk'], 1, 0);
            $pdf->Cell(30, 20, $item['jenis_bunga'], 1, 0);
            $pdf->Cell(45, 20, $item['tipe_buket'], 1, 0);
            $pdf->Cell(35, 20, $item['harga'], 1, 1);
        }
        $response = service('response');
        $response->setHeader('Content-Type', 'application/pdf');

        $pdf->Output('D', 'florist.pdf');
    }
}
