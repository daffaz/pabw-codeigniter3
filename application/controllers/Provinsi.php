<?php
defined('BASEPATH') or exit('No direct script access allowed');

// ME-LOAD LIBRARY PHPSPREADSHEET
require('./excel/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Provinsi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ProvinsiModel');
        $this->load->helper('form');
    }
    public function index()
    {
        $provinsi = $this->ProvinsiModel->listing();
        $data =  ['title' => 'Laporan Excel', 'provinsi' => $provinsi];
        $this->load->view('provinsi_v', $data, FALSE);
    }
    public function export()
    {
        $provinsi = $this->ProvinsiModel->listing();
        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();

        // Set document properties
        $spreadsheet->getProperties()->setTitle('Office 2007 XLSX Test Document')
            ->setSubject('Office 2007 XLSX Test Document')
            ->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
            ->setKeywords('office 2007 openxml php')
            ->setCategory('Test result file');

        // Add some data
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'KODE PROVINSI')
            ->setCellValue('B1', 'NAMA PROVINSI');

        // Miscellaneous glyphs, UTF-8
        $i = 2;
        foreach ($provinsi as $provinsi) {

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $i, $provinsi->id_provinsi)
                ->setCellValue('B' . $i, $provinsi->nama_provinsi);
            $i++;
        }

        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('Report Excel ' . date('d-m-Y H'));

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Report Excel.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }
    public function upload()
    {
        $config['upload_path'] = './ngeupload/';
        $config['allowed_types'] = 'xlsx';
        $config['max_size'] = 1000;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('userupload')) {
            // $error = ['error' => $this->upload->display_errors()];
            // $this->load->view('provinsi_v', $error);
            echo "gagal";
        } else {
            $data = ['upload_data' => $this->upload->data()];
            $m = $this->upload->data();
            $this->import($m['file_name']);
            // print_r($m);
            // echo "suckses";
        }
    }
    public function import($file)
    {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load('ngeupload/' . $file);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();
        print("ini mengimport ");
        //var_dump($sheetData);
        print(count($sheetData));
        //Bagian data mulai ke dua, berarti indeks 1
        for ($i = 1; $i < count($sheetData); $i++) {
            $id = $sheetData[$i][0]; #id
            $nama_prov = $sheetData[$i][1]; #nama
            echo "<br>" . $id . " " . $nama_prov;
        }
        //menulis ke database nih baru, sebenernya bisa disisipkan di bagian atas pas looping
        for ($i = 1; $i < count($sheetData); $i++) {
            //perhatikan indeks harus sama dengan field atau column di database
            $data[$i]['id_provinsi'] = $sheetData[$i][0]; #id
            $data[$i]['nama_provinsi'] = $sheetData[$i][1]; #nama
        }
        print_r($data);
        $this->ProvinsiModel->tuliskedb($data);
    }
}
