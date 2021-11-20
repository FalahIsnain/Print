<?php

namespace App\Modules\Admin\Controllers;

use App\Modules\Admin\Models\floristModel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class CetakExcell extends BaseController
{
    protected $floristModel;

    public function __construct()
    {
        $this->floristModel = new floristModel();
    }

    function index()
    {
        $spreadsheet = new Spreadsheet();

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', 'LAPORAN DATA Penjualan');

        $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(13);

        $spreadsheet->getActiveSheet()->mergeCells('A1:H1');

        $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal('center');

        $spreadsheet->getActiveSheet()
            ->setCellValue('A3', 'NO')
            ->setCellValue('B3', 'GAMBAR')
            ->setCellValue('C3', 'NAMA PRODUK')
            ->setCellValue('D3', 'JENIS BUNGA')
            ->setCellValue('E3', 'TIPE BUKET')
            ->setCellValue('F3', 'HARGA');


        $spreadsheet->getActiveSheet()->getStyle('A1:F3')->getFont()->setBold(true);

        $florist = $this->floristModel->getBunga();
        $i = 1;
        $rowID = 4;
        foreach ($florist as $item) {
            $spreadsheet->getActiveSheet()
                ->setCellValue('A' . $rowID, $i++)
                ->setCellValue('C' . $rowID, $item['nama_produk'])
                ->setCellValue('D' . $rowID, $item['jenis_bunga'])
                ->setCellValue('E' . $rowID, $item['tipe_buket'])
                ->setCellValue('F' . $rowID, $item['harga']);


            $foto = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $foto->setPath('img/upload/' . $item['gambar']);
            $foto->setCoordinates('B' . $rowID);
            $foto->setOffsetX(5);
            $foto->setOffsetY(5);
            $foto->setWidth(70);
            $foto->setHeight(70);
            $foto->setWorksheet($spreadsheet->getActiveSheet());

            $spreadsheet->getActiveSheet()->getRowDimension($rowID)->setRowHeight(50);
            $rowID++;
        }

        foreach (range('A', 'F') as $ColumnID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($ColumnID)->setAutoSize(true);
        }


        $border = array(
            'allBorder' => array(
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
            )
        );

        $spreadsheet->getActiveSheet()->getStyle('A3' . ':F' . ($rowID - 1))
            ->getBorders()->applyFromArray($border);

        $alignmet = array(
            'alignment' => array(
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            )
        );

        $spreadsheet->getActiveSheet()->getStyle('A3' . ':F' . ($rowID - 1))->applyFromArray($alignmet);


        $filename = 'dataflrst-Excel.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadseetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cahce-Control: max-age=0');

        $objWriter = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $objWriter->save('php://output');
        exit;
    }
}
