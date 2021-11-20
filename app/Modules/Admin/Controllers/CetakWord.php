<?php

namespace App\Modules\Admin\Controllers;

use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use App\Modules\Admin\Models\floristModel;


class CetakWord extends BaseController
{
    protected $floristModel;

    public function __construct()
    {
        $this->floristModel = new floristModel();
    }

    function index()
    {
        $word = new PhpWord();
        $sect = $word->addSection();
        $title = array('size' => 16, 'bold' => true);
        $sect->addText("Laporan Data Penjualan", $title);
        $sect->addTextBreak(1);

        $styleTable = array('borderSize' => 6, 'borderColor' => '006699', 'cellMargin' => 80);
        $styleCell = array('valign' => 'center');
        $fontHeader = array('bold' => true);
        $noSpace = array('spaceAfter' => 0);
        $imgStyle = array('width' => 50, 'height' => 50);

        $word->addTableStyle('mytable', $styleTable);
        $table = $sect->addTable('mytable');
        $table->addRow();
        $table->addCell(500, $styleCell)->addText('NO', $fontHeader, $noSpace);
        $table->addCell(2000, $styleCell)->addText('GAMBAR', $fontHeader, $noSpace);
        $table->addCell(2000, $styleCell)->addText('NAMA PRODUK', $fontHeader, $noSpace);
        $table->addCell(2000, $styleCell)->addText('JENIS BUNGA', $fontHeader, $noSpace);
        $table->addCell(2000, $styleCell)->addText('TIPE BUKET', $fontHeader, $noSpace);
        $table->addCell(2000, $styleCell)->addText('HARGA', $fontHeader, $noSpace);


        $florist = $this->floristModel->getBunga();
        $i = 1;

        foreach ($florist as $item) {
            $table->addRow();
            $table->addCell(500, $styleCell)->addText($i++, array(), $noSpace);
            $table->addCell(1000, $styleCell)->addImage('img/upload/' . $item['gambar'], $imgStyle);
            $table->addCell(2000, $styleCell)->addText($item['nama_produk'], array(), $noSpace);
            $table->addCell(2000, $styleCell)->addText($item['jenis_bunga'], array(), $noSpace);
            $table->addCell(2000, $styleCell)->addText($item['tipe_buket'], array(), $noSpace);
            $table->addCell(2000, $styleCell)->addText($item['harga'], array(), $noSpace);
        }

        $filename = "dataflrst-word.docx";
        header('Content-Type: application/msword');
        header('Content-Disposition: attachment;filename="' . $filename . '"');

        $objWriter = IOFactory::createWriter($word, 'Word2007');
        $objWriter->save('php://output');
        exit;
    }
}
